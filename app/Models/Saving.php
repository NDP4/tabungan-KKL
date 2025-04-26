<?php

namespace App\Models;

use App\Services\NotificationService;
use App\Services\SavingsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use App\Notifications\SavingApproved;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sequence_number',
        'amount',
        'week_number',
        'payment_method',
        'status',
        'proof_file',
        'notes',
        'rejection_reason',
        'created_by',
        'confirmed_by',
        'receipt_path',
        'is_confirmed_by_other',
        'confirmed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_confirmed_by_other' => 'boolean',
        'confirmed_at' => 'datetime',
        'week_number' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($saving) {
            if (is_null($saving->week_number)) {
                $saving->week_number = app(SavingsService::class)->calculateWeekNumber();
            }

            if (!$saving->sequence_number) {
                // Get last successful sequence number for this user
                $lastSaving = static::where('user_id', $saving->user_id)
                    ->whereIn('status', ['approved', 'pending'])
                    ->orderBy('sequence_number', 'desc')
                    ->first();

                $saving->sequence_number = $lastSaving ? $lastSaving->sequence_number + 1 : 1;
            }
        });
    }

    protected static function booted()
    {
        static::updated(function ($saving) {
            if ($saving->isDirty('status') && $saving->status === 'approved') {
                $saving->user->notify(new SavingApproved($saving));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function confirmedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public static function calculateWeekNumber(): int
    {
        $startDate = Carbon::parse('2024-01-01'); // Adjust this to your program start date
        return Carbon::now()->diffInWeeks($startDate) + 1;
    }

    public function getWhatsappMessage(): string
    {
        return sprintf(
            "Halo Bendahara, saya *%s* dengan NIM *%s* telah menabung ke *%d* sebesar *Rp %s* dengan metode *%s*. Catatan: *%s*",
            $this->user->name,
            $this->user->nim,
            $this->sequence_number,
            number_format($this->amount, 0, ',', '.'),
            $this->payment_method,
            $this->notes ?? '-'
        );
    }

    public function getWhatsappUrl(): string
    {
        $adminPhone = settings('admin_phone', '6285866233841');
        return "https://wa.me/{$adminPhone}?text=" . urlencode($this->getWhatsappMessage());
    }

    public function confirm(?User $user): bool
    {
        if (!$user || !$this->canConfirm($user)) {
            return false;
        }

        $wasConfirmed = $this->update([
            'is_confirmed_by_other' => true,
            'confirmed_by' => $user->id,
            'confirmed_at' => now(),
        ]);

        if ($wasConfirmed) {
            $notificationService = app(NotificationService::class);
            $notificationService->notifySavingApproved($this);

            $totalSavings = $this->creator->total_savings;
            $progress = $this->creator->progress;

            $notificationService->sendPaymentConfirmation($this, $totalSavings, $progress);
        }

        return true;
    }

    public function reject(User $user, string $reason): bool
    {
        if (!$this->canConfirm($user)) {
            return false;
        }

        $wasRejected = $this->delete();

        if ($wasRejected) {
            app(NotificationService::class)->notifySavingRejected($this, $reason);
        }

        return $wasRejected;
    }

    public function canConfirm(User $user): bool
    {
        return !$this->is_confirmed_by_other &&
            $user->id !== $this->created_by &&
            in_array($user->role, ['bendahara', 'panitia']);
    }

    public function getWeekRangeAttribute(): array
    {
        return app(SavingsService::class)->getWeekRange($this->week_number);
    }

    public function getFormattedWeekAttribute(): string
    {
        if ($this->week_number === -1) {
            return 'Pra-Program';
        }
        return "Minggu ke-{$this->week_number}";
    }
}

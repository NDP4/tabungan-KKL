<?php

namespace App\Models;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'created_by',
        'is_confirmed_by_other',
        'confirmed_by',
        'confirmed_at',
        'notes',
        'receipt_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_confirmed_by_other' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function confirmedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
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
            app(NotificationService::class)->notifyExpenseConfirmed($this);
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
            app(NotificationService::class)->notifyExpenseRejected($this, $reason);
        }

        return $wasRejected;
    }

    public function canConfirm(User $user): bool
    {
        return !$this->is_confirmed_by_other &&
            $user->id !== $this->created_by &&
            in_array($user->role, ['bendahara', 'panitia']);
    }

    protected static function booted()
    {
        static::created(function ($expense) {
            $treasurers = User::where('role', 'bendahara')->get()->all();
            app(NotificationService::class)->notifyExpenseSubmitted($expense, $treasurers);
        });
    }
}

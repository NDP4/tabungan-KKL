<?php

namespace App\Models;

use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasNotifications;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasNotifications;

    protected $fillable = [
        'name',
        'email',
        'nim',
        'password',
        'role',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['bendahara', 'panitia']);
    }

    public function savings(): HasMany
    {
        return $this->hasMany(Saving::class, 'user_id');
    }

    public function confirmedSavings(): HasMany
    {
        return $this->hasMany(Saving::class, 'confirmed_by');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'created_by');
    }

    public function confirmedExpenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'confirmed_by');
    }

    public function getTotalSavingsAttribute(): float
    {
        return (float) $this->savings()
            ->where('status', 'approved')
            ->sum('amount');
    }

    public function getWeeklySavingsAttribute(): float
    {
        return (float) $this->savings()
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->startOfWeek())
            ->sum('amount');
    }

    public function getProgressAttribute(): float
    {
        $target = config('kkl.target_amount', 1950000);
        return ($this->total_savings / $target) * 100;
    }

    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }
}

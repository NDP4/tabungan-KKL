<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Saving;

class SavingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Saving $saving): bool
    {
        return $user->id === $saving->user_id ||
            in_array($user->role, ['ketua', 'bendahara']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'mahasiswa';
    }

    public function update(User $user, Saving $saving): bool
    {
        return $user->id === $saving->user_id && $saving->status === 'pending';
    }

    public function delete(User $user, Saving $saving): bool
    {
        return $user->id === $saving->user_id && $saving->status === 'pending';
    }

    public function approve(User $user): bool
    {
        return in_array($user->role, ['ketua', 'bendahara']);
    }

    public function reject(User $user): bool
    {
        return in_array($user->role, ['ketua', 'bendahara']);
    }
}

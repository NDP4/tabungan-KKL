<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['ketua', 'bendahara']);
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id ||
            in_array($user->role, ['ketua', 'bendahara']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'ketua';
    }

    public function update(User $user, User $model): bool
    {
        return $user->role === 'ketua' || $user->id === $model->id;
    }

    public function delete(User $user): bool
    {
        return $user->role === 'ketua';
    }

    public function updateRole(User $user): bool
    {
        return $user->role === 'ketua';
    }
}

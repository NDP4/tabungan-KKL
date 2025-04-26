<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['panitia', 'bendahara']);
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id ||
            in_array($user->role, ['panitia', 'bendahara']);
    }

    public function create(User $user): bool
    {
        return $user->role === 'panitia';
    }

    public function update(User $user, User $model): bool
    {
        if ($user->role === 'panitia') {
            return true;
        }
        return $user->id === $model->id;
    }

    public function delete(User $user): bool
    {
        return $user->role === 'panitia';
    }

    public function updateRole(User $user): bool
    {
        return $user->role === 'panitia';
    }
}

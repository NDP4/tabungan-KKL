<?php

namespace App\Broadcasting;

use App\Models\User;

class ExpensesChannel
{
    public function join(User $user): array|bool
    {
        return in_array($user->role, ['bendahara', 'panitia']) ? [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role
        ] : false;
    }
}

<?php

namespace App\Broadcasting;

use App\Models\User;

class SavingsChannel
{
    public function join(User $user): array|bool
    {
        return [
            'id' => $user->id,
            'name' => $user->name
        ];
    }
}

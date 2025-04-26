<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateUserLastLogin
{
    public function handle(Login $event): void
    {
        $event->user->updateLastLogin();
    }
}

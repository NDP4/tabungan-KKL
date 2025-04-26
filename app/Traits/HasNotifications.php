<?php

namespace App\Traits;

use Illuminate\Notifications\Notifiable;

trait HasNotifications
{
    public function receivesBroadcastNotificationsOn()
    {
        return 'notifications.' . $this->id;
    }
}

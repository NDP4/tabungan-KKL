<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class SetoranNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $setoran;
    public $status;
    public $message;

    public function __construct($setoran, $status, $message)
    {
        $this->setoran = $setoran;
        $this->status = $status;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'setoran_id' => $this->setoran->id,
            'status' => $this->status,
            'message' => $this->message,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'setoran_id' => $this->setoran->id,
            'status' => $this->status,
            'message' => $this->message,
        ]);
    }
}

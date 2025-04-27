<?php

namespace App\Notifications;

use App\Models\Saving;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewSavingNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Saving $saving
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'icon' => 'heroicon-o-banknotes',
            'title' => 'Setoran Baru',
            'message' => "{$this->saving->user->name} telah menabung sebesar Rp " . number_format($this->saving->amount, 0, ',', '.'),
            'saving_id' => $this->saving->id,
            'url' => route('filament.admin.resources.savings.edit', $this->saving)
        ];
    }
}

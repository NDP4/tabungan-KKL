<?php

namespace App\Notifications;

use App\Models\Saving;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SavingRejected extends Notification
{
    use Queueable;

    public function __construct(
        private Saving $saving,
        private string $reason
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Setoran KKL Ditolak')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Setoran KKL anda sebesar Rp ' . number_format($this->saving->amount, 0, ',', '.') . ' ditolak.')
            ->line('Alasan: ' . $this->reason)
            ->line('Silakan coba lagi dengan memperbaiki masalah tersebut.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'saving_id' => $this->saving->id,
            'amount' => $this->saving->amount,
            'reason' => $this->reason,
            'message' => 'Setoran KKL anda ditolak'
        ];
    }
}

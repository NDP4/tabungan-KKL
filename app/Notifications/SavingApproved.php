<?php

namespace App\Notifications;

use App\Models\Saving;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SavingApproved extends Notification
{
    use Queueable;

    public function __construct(
        private Saving $saving
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Setoran KKL Disetujui')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Setoran KKL anda sebesar Rp ' . number_format($this->saving->amount, 0, ',', '.') . ' telah disetujui oleh ' . $this->saving->confirmedByUser->name . '.')
            ->line('Terima kasih atas kontribusi anda!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'saving_id' => $this->saving->id,
            'amount' => $this->saving->amount,
            'confirmed_by' => $this->saving->confirmedByUser->name,
            'message' => 'Setoran KKL anda telah disetujui oleh ' . $this->saving->confirmedByUser->name
        ];
    }
}

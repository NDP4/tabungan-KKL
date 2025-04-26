<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LowBalanceAlert extends Notification
{
    use Queueable;

    public function __construct(
        private float $currentBalance,
        private float $threshold
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Peringatan Saldo Rendah')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Saldo KKL saat ini sudah di bawah batas minimum.')
            ->line('Saldo saat ini: Rp ' . number_format($this->currentBalance, 0, ',', '.'))
            ->line('Batas minimum: Rp ' . number_format($this->threshold, 0, ',', '.'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'current_balance' => $this->currentBalance,
            'threshold' => $this->threshold,
            'message' => 'Peringatan saldo di bawah batas minimum'
        ];
    }
}

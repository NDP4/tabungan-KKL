<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WeeklySavingsReminder extends Notification
{
    use Queueable;

    public function __construct(
        private float $targetAmount,
        private float $currentAmount
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $remaining = $this->targetAmount - $this->currentAmount;

        return (new MailMessage)
            ->subject('Pengingat Setoran KKL Minggu Ini')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Minggu ini kamu belum mencapai target setoran mingguan KKL.')
            ->line('Target: Rp ' . number_format($this->targetAmount, 0, ',', '.'))
            ->line('Sudah disetor: Rp ' . number_format($this->currentAmount, 0, ',', '.'))
            ->line('Sisa yang perlu disetor: Rp ' . number_format($remaining, 0, ',', '.'))
            ->action('Setor Sekarang', url('/dashboard'))
            ->line('Yuk segera setor untuk mencapai target KKL kita!');
    }
}

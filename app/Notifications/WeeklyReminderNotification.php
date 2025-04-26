<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WeeklyReminderNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengingat Setoran KKL Mingguan')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Ini adalah pengingat untuk setoran KKL mingguan anda.')
            ->line('Target mingguan: Rp ' . number_format(config('kkl.weekly_target'), 0, ',', '.'))
            ->action('Setor Sekarang', url('/dashboard'))
            ->line('Jangan lupa untuk melakukan setoran mingguan anda!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Pengingat setoran KKL mingguan',
            'target' => config('kkl.weekly_target')
        ];
    }
}

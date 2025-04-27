<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WeeklyReminder extends Notification
{
    use Queueable;

    public function __construct(
        protected float $targetAmount,
        protected float $currentAmount
    ) {}

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengingat Setoran KKL Minggu Ini')
            ->view('emails.weekly-reminder', [
                'notifiable' => $notifiable,
                'targetAmount' => $this->targetAmount,
                'currentAmount' => $this->currentAmount
            ]);
    }
}

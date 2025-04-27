<?php

namespace App\Notifications;

use App\Models\Saving;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SavingApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Saving $saving,
        protected float $totalSavings,
        protected float $progress
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Setoran KKL Disetujui')
            ->view('emails.payment-confirmation', [
                'saving' => $this->saving,
                'totalSavings' => $this->totalSavings,
                'progress' => $this->progress
            ]);
    }
}

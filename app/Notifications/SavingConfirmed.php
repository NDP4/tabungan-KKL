<?php

namespace App\Notifications;

use App\Models\Saving;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SavingConfirmed extends Notification
{
    use Queueable;

    public function __construct(protected Saving $saving) {}

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $totalSavings = $this->saving->user->total_savings;
        $targetAmount = config('kkl.target_amount', 1950000);
        $progress = ($totalSavings / $targetAmount) * 100;

        return (new MailMessage)
            ->subject('Konfirmasi Setoran KKL')
            ->view('emails.payment-confirmation', [
                'saving' => $this->saving,
                'totalSavings' => $totalSavings,
                'progress' => $progress
            ]);
    }
}

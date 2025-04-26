<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SavingSubmitted extends Notification
{
    use Queueable;

    protected $user;
    protected $amount;

    public function __construct(User $user, float $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Saving Submission')
            ->line("A new saving of Rp. " . number_format($this->amount, 2) . " has been submitted by " . $this->user->name)
            ->action('View Submission', url('/savings'))
            ->line('Please review this submission.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New saving submission of Rp. " . number_format($this->amount, 2) . " by " . $this->user->name,
            'amount' => $this->amount,
            'user_id' => $this->user->id,
            'type' => 'saving_submitted'
        ];
    }
}

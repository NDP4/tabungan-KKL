<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reset Password ' . config('app.name'))
            ->view('emails.password-reset', [
                'resetUrl' => $this->resetUrl($notifiable),
                'name' => $notifiable->name,
                'count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')
            ]);
    }
}

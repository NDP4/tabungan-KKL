<?php

namespace App\Notifications;

use App\Models\Saving;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SavingSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        private Saving $saving
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'icon' => 'heroicon-o-banknotes',
            'title' => 'Setoran Baru',
            'saving_id' => $this->saving->id,
            'amount' => $this->saving->amount,
            'student_name' => $this->saving->user->name,
            'payment_method' => $this->saving->payment_method,
            'message' => "Setoran baru dari {$this->saving->user->name} sebesar Rp" . number_format($this->saving->amount, 0, ',', '.'),
            'url' => route('filament.admin.resources.savings.edit', $this->saving)
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExpenseConfirmed extends Notification
{
    use Queueable;

    public function __construct(
        private Expense $expense
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengeluaran Dikonfirmasi')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Pengeluaran sebesar Rp ' . number_format($this->expense->amount, 0, ',', '.') . ' telah dikonfirmasi.')
            ->line('Deskripsi: ' . $this->expense->description);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'expense_id' => $this->expense->id,
            'amount' => $this->expense->amount,
            'description' => $this->expense->description,
            'message' => 'Pengeluaran telah dikonfirmasi'
        ];
    }
}

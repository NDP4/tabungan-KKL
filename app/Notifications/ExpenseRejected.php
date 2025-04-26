<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExpenseRejected extends Notification
{
    use Queueable;

    public function __construct(
        private Expense $expense,
        private string $reason
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengeluaran Ditolak')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Pengeluaran sebesar Rp ' . number_format($this->expense->amount, 0, ',', '.') . ' ditolak.')
            ->line('Alasan: ' . $this->reason)
            ->line('Deskripsi pengeluaran: ' . $this->expense->description);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'expense_id' => $this->expense->id,
            'amount' => $this->expense->amount,
            'reason' => $this->reason,
            'description' => $this->expense->description,
            'message' => 'Pengeluaran ditolak'
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MonthlyReportNotification extends Notification
{
    use Queueable;

    public function __construct(
        private array $summary
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Laporan Bulanan KKL')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Berikut adalah ringkasan tabungan KKL bulan ini:')
            ->line('Total setoran: Rp ' . number_format($this->summary['total_savings'], 0, ',', '.'))
            ->line('Jumlah mahasiswa yang mencapai target: ' . $this->summary['target_achieved_count'])
            ->line('Rata-rata progres: ' . number_format($this->summary['average_progress'], 1) . '%');
    }

    public function toArray(object $notifiable): array
    {
        return $this->summary;
    }
}

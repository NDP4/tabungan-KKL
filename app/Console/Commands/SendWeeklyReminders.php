<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendWeeklyReminders extends Command
{
    protected $signature = 'app:send-weekly-reminders';
    protected $description = 'Send weekly savings reminders to students';

    public function handle(NotificationService $notificationService): int
    {
        $students = User::where('role', 'mahasiswa')
            ->whereDoesntHave('savings', function ($query) {
                $query->where('created_at', '>=', now()->startOfWeek());
            })
            ->get()
            ->all();

        $notificationService->sendWeeklyReminders($students);

        $this->info("Sent weekly reminders to " . count($students) . " students.");
        return Command::SUCCESS;
    }
}

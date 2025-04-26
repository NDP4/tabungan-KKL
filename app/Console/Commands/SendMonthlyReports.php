<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendMonthlyReports extends Command
{
    protected $signature = 'app:send-monthly-reports';
    protected $description = 'Send monthly savings reports to treasurers';

    public function handle(NotificationService $notificationService): int
    {
        $treasurers = User::where('role', 'bendahara')->get();
        $students = User::where('role', 'mahasiswa')->get();

        $summary = [
            'total_savings' => $students->sum('total_savings'),
            'target_achieved_count' => $students->filter(fn($student) => $student->progress >= 100)->count(),
            'average_progress' => $students->avg('progress'),
        ];

        foreach ($treasurers as $treasurer) {
            $notificationService->sendMonthlyReport($treasurer, $summary);
        }

        $this->info("Sent monthly reports to {$treasurers->count()} treasurers.");
        return Command::SUCCESS;
    }
}

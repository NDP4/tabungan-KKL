<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Send reminders every Monday at 9 AM
        $schedule->command('app:send-weekly-reminders')
            ->weeklyOn(1, '09:00')
            ->timezone('Asia/Jakarta');
        $schedule->command('app:send-weekly-reminders')->weekly()->mondays()->at('09:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}

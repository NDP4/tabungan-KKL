<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WeeklyReminder;
use Illuminate\Console\Command;

class SendWeeklyReminders extends Command
{
    protected $signature = 'app:send-weekly-reminders';
    protected $description = 'Send weekly savings reminder to users who haven\'t met their target';

    public function handle(): void
    {
        $weeklyTarget = config('kkl.weekly_target', 50000);

        User::where('role', 'mahasiswa')->chunk(100, function ($users) use ($weeklyTarget) {
            foreach ($users as $user) {
                $weeklySavings = $user->weekly_savings;

                if ($weeklySavings < $weeklyTarget) {
                    $user->notify(new WeeklyReminder(
                        targetAmount: $weeklyTarget,
                        currentAmount: $weeklySavings
                    ));
                }
            }
        });

        $this->info('Weekly reminders sent successfully.');
    }
}

<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\SavingsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WeeklySavingsReminder;

class SendWeeklyReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(SavingsService $savingsService): void
    {
        $users = User::where('role', 'mahasiswa')->get();

        foreach ($users as $user) {
            if (!$savingsService->hasMetWeeklyTarget($user)) {
                Notification::send($user, new WeeklySavingsReminder(
                    $savingsService->getWeeklyTarget(),
                    $user->weekly_savings
                ));
            }
        }
    }
}

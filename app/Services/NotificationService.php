<?php

namespace App\Services;

use App\Models\User;
use App\Models\Saving;
use App\Models\Expense;
use App\Mail\PaymentConfirmationMail;
use App\Notifications\{
    SavingApproved,
    SavingRejected,
    ExpenseConfirmed,
    ExpenseSubmitted,
    ExpenseApproved,
    ExpenseRejected,
    WeeklyReminderNotification,
    MonthlyReportNotification,
    LowBalanceAlert
};
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function notifySavingApproved(Saving $saving): void
    {
        $saving->creator->notify(new SavingApproved($saving));
    }

    public function notifySavingRejected(Saving $saving, string $reason): void
    {
        $saving->creator->notify(new SavingRejected($saving, $reason));
    }

    public function notifyExpenseConfirmed(Expense $expense): void
    {
        $expense->creator->notify(new ExpenseConfirmed($expense));
    }

    public function sendWeeklyReminders(array $users): void
    {
        foreach ($users as $user) {
            $user->notify(new WeeklyReminderNotification());
        }
    }

    public function sendMonthlyReport(User $admin, array $summary): void
    {
        $admin->notify(new MonthlyReportNotification($summary));
    }

    public function sendLowBalanceAlert(User $treasurer, float $currentBalance, float $threshold): void
    {
        $treasurer->notify(new LowBalanceAlert($currentBalance, $threshold));
    }

    public function notifyExpenseSubmitted(Expense $expense, array $treasurers): void
    {
        Notification::send($treasurers, new ExpenseSubmitted($expense));
    }

    public function notifyExpenseApproved(Expense $expense): void
    {
        $expense->creator->notify(new ExpenseApproved($expense));
    }

    public function notifyExpenseRejected(Expense $expense, string $reason): void
    {
        $expense->creator->notify(new ExpenseRejected($expense, $reason));
    }

    public function sendPaymentConfirmation(Saving $saving, float $totalSavings, float $progress): void
    {
        Mail::to($saving->creator)->send(new PaymentConfirmationMail($saving, $totalSavings, $progress));
    }
}

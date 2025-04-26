<?php

namespace App\Actions;

use App\Models\Expense;
use App\Models\User;
use App\Events\ExpenseConfirmed;
use Illuminate\Support\Facades\DB;

class ConfirmExpense
{
    public function execute(Expense $expense, User $confirmedBy): bool
    {
        return DB::transaction(function () use ($expense, $confirmedBy) {
            $expense->update([
                'is_confirmed_by_other' => true,
                'confirmed_by' => $confirmedBy->id,
                'confirmed_at' => now(),
            ]);

            event(new ExpenseConfirmed($expense));

            return true;
        });
    }
}

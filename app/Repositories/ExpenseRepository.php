<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ExpenseRepository
{
    public function createExpense(User $creator, array $data): Expense
    {
        return Expense::create([
            'description' => $data['description'],
            'amount' => $data['amount'],
            'created_by' => $creator->id,
            'is_confirmed_by_other' => false,
        ]);
    }

    public function confirmExpense(Expense $expense, User $confirmer): bool
    {
        if ($expense->created_by === $confirmer->id) {
            return false;
        }

        return $expense->update([
            'is_confirmed_by_other' => true,
            'confirmed_by' => $confirmer->id,
            'confirmed_at' => now(),
        ]);
    }

    public function getPendingExpenses(): Collection
    {
        return Expense::with(['creator', 'confirmedByUser'])
            ->where('is_confirmed_by_other', false)
            ->latest()
            ->get();
    }

    public function getMonthlyExpenses(int $month, int $year): Collection
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        return Expense::with(['creator', 'confirmedByUser'])
            ->where('is_confirmed_by_other', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();
    }

    public function getTotalExpenses(): float
    {
        return Expense::where('is_confirmed_by_other', true)->sum('amount');
    }

    public function getRecentExpenses(int $limit = 5): Collection
    {
        return Expense::with(['creator', 'confirmedByUser'])
            ->where('is_confirmed_by_other', true)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function updateExpense(Expense $expense, array $data): bool
    {
        if ($expense->is_confirmed_by_other) {
            return false;
        }

        return $expense->update([
            'description' => $data['description'],
            'amount' => $data['amount'],
        ]);
    }

    public function deleteExpense(Expense $expense): bool
    {
        if ($expense->is_confirmed_by_other) {
            return false;
        }

        return $expense->delete();
    }
}

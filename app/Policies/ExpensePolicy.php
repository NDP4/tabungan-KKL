<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;

class ExpensePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['ketua', 'bendahara', 'panitia']);
    }

    public function view(User $user, Expense $expense): bool
    {
        return in_array($user->role, ['ketua', 'bendahara', 'panitia']) ||
            $user->id === $expense->created_by;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['ketua', 'bendahara']);
    }

    public function update(User $user, ?Expense $expense = null): bool
    {
        if (!$expense) {
            return in_array($user->role, ['ketua', 'bendahara']);
        }
        return $user->id === $expense->created_by && !$expense->is_confirmed_by_other;
    }

    public function delete(User $user, ?Expense $expense = null): bool
    {
        if (!$expense) {
            return in_array($user->role, ['ketua', 'bendahara']);
        }
        return $user->id === $expense->created_by && !$expense->is_confirmed_by_other;
    }

    public function approve(User $user): bool
    {
        return $user->role === 'ketua';
    }

    public function confirm(User $user, Expense $expense): bool
    {
        return !$expense->is_confirmed_by_other &&
            $user->role === 'panitia' &&
            $expense->creator->role === 'bendahara';
    }
}

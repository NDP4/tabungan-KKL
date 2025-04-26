<?php

namespace App\Services;

use App\Models\User;
use App\Models\Saving;
use App\Models\Expense;
use Illuminate\Support\Collection;
use PDF;
use Carbon\Carbon;
use App\Helpers\MoneyFormatter;

class ReportGeneratorService
{
    public function generateMonthlyReport(int $month, int $year): string
    {
        $date = Carbon::create($year, $month, 1);
        $savings = Saving::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'approved')
            ->with('user')
            ->get();

        $expenses = Expense::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('is_confirmed_by_other', true)
            ->with(['creator', 'confirmedByUser'])
            ->get();

        $totalSavings = $savings->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $balance = $totalSavings - $totalExpenses;

        $pdf = PDF::loadView('reports.monthly', compact(
            'date',
            'savings',
            'expenses',
            'totalSavings',
            'totalExpenses',
            'balance'
        ));

        return $pdf->output();
    }

    public function generateStudentReport(User $student): string
    {
        $savings = $student->savings()
            ->where('status', 'approved')
            ->orderBy('created_at')
            ->get();

        $totalSaved = $savings->sum('amount');
        $targetAmount = config('kkl.target_amount');
        $progress = MoneyFormatter::percentage($totalSaved, $targetAmount);

        $pdf = PDF::loadView('reports.student', compact(
            'student',
            'savings',
            'totalSaved',
            'targetAmount',
            'progress'
        ));

        return $pdf->output();
    }

    public function generateClassReport(): string
    {
        $students = User::where('role', 'mahasiswa')
            ->with(['savings' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->get();

        $targetAmount = config('kkl.target_amount');
        $totalClassSavings = Saving::where('status', 'approved')->sum('amount');
        $totalExpenses = Expense::where('is_confirmed_by_other', true)->sum('amount');
        $balance = $totalClassSavings - $totalExpenses;

        $studentsProgress = $students->map(function ($student) use ($targetAmount) {
            $totalSaved = $student->savings->sum('amount');
            return [
                'name' => $student->name,
                'total_saved' => $totalSaved,
                'progress' => MoneyFormatter::percentage($totalSaved, $targetAmount)
            ];
        });

        $pdf = PDF::loadView('reports.class', compact(
            'studentsProgress',
            'totalClassSavings',
            'totalExpenses',
            'balance',
            'targetAmount'
        ));

        return $pdf->output();
    }
}

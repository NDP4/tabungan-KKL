<?php

namespace App\Services;

use App\Models\Saving;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportService
{
    public function generateMonthlyReport(int $month, int $year): string
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $savings = Saving::with('user')
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        $expenses = Expense::with(['creator', 'confirmedByUser'])
            ->where('is_confirmed_by_other', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        $data = [
            'month' => $startDate->format('F Y'),
            'total_savings' => $savings->sum('amount'),
            'total_expenses' => $expenses->sum('amount'),
            'savings' => $savings,
            'expenses' => $expenses,
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('pdf.monthly-report', $data);
        $filename = 'laporan-bulanan-' . $startDate->format('Y-m') . '.pdf';
        $path = storage_path('app/public/reports/' . $filename);

        $pdf->save($path);
        return $filename;
    }

    public function generateStudentReport(User $student): string
    {
        $savings = $student->savings()
            ->where('status', 'approved')
            ->orderBy('created_at')
            ->get();

        $data = [
            'student' => $student,
            'total_savings' => $savings->sum('amount'),
            'savings' => $savings,
            'target_amount' => 1950000,
            'progress_percentage' => min(($savings->sum('amount') / 1950000) * 100, 100),
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = PDF::loadView('pdf.student-report', $data);
        $filename = 'laporan-mahasiswa-' . $student->nim . '.pdf';
        $path = storage_path('app/public/reports/' . $filename);

        $pdf->save($path);
        return $filename;
    }

    public function generateSummaryReport(): string
    {
        $students = User::where('role', 'mahasiswa')->get();
        $totalTarget = $students->count() * 1950000;

        $summaryData = $students->map(function ($student) {
            $totalSavings = $student->savings()
                ->where('status', 'approved')
                ->sum('amount');

            return [
                'name' => $student->name,
                'nim' => $student->nim,
                'total_savings' => $totalSavings,
                'progress' => min(($totalSavings / 1950000) * 100, 100),
            ];
        })->sortByDesc('progress');

        $data = [
            'students' => $summaryData,
            'total_collected' => Saving::where('status', 'approved')->sum('amount'),
            'total_target' => $totalTarget,
            'total_expenses' => Expense::where('is_confirmed_by_other', true)->sum('amount'),
            'total_students' => $students->count(),
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = PDF::loadView('pdf.summary-report', $data);
        $filename = 'laporan-ringkasan-' . now()->format('Y-m-d') . '.pdf';
        $path = storage_path('app/public/reports/' . $filename);

        $pdf->save($path);
        return $filename;
    }
}

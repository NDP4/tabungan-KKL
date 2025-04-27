<?php

namespace App\Services;

use App\Models\User;
use App\Models\Saving;
use App\Models\Expense;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ExportService
{
    public function exportSavingsToExcel(): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Minggu Ke');
        $sheet->setCellValue('F1', 'Metode');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Dikonfirmasi Oleh');

        $savings = Saving::with(['user', 'confirmedByUser'])->orderBy('created_at')->get();

        $row = 2;
        foreach ($savings as $saving) {
            $sheet->setCellValue('A' . $row, $saving->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $saving->user->nim);
            $sheet->setCellValue('C' . $row, $saving->user->name);
            $sheet->setCellValue('D' . $row, $saving->amount);
            $sheet->setCellValue('E' . $row, $saving->week_number);
            $sheet->setCellValue('F' . $row, $saving->payment_method);
            $sheet->setCellValue('G' . $row, $saving->status);
            $sheet->setCellValue('H' . $row, $saving->confirmedByUser?->name ?? '-');
            $row++;
        }

        $filename = 'rekap-setoran-' . now()->format('Y-m-d') . '.xlsx';
        $path = storage_path('app/public/exports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return $filename;
    }

    public function exportStudentsToExcel(): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'NIM');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Total Setoran');
        $sheet->setCellValue('E1', 'Progress');
        $sheet->setCellValue('F1', 'Status Email');
        $sheet->setCellValue('G1', 'Terakhir Login');

        $students = User::where('role', 'mahasiswa')
            ->withSum(['savings' => fn($q) => $q->where('status', 'approved')], 'amount')
            ->get();

        $row = 2;
        foreach ($students as $student) {
            $totalSavings = $student->savings_sum_amount ?? 0;
            $progress = min(($totalSavings / config('kkl.target_amount', 1950000)) * 100, 100);

            $sheet->setCellValue('A' . $row, $student->nim);
            $sheet->setCellValue('B' . $row, $student->name);
            $sheet->setCellValue('C' . $row, $student->email);
            $sheet->setCellValue('D' . $row, $totalSavings);
            $sheet->setCellValue('E' . $row, number_format($progress, 1) . '%');
            $sheet->setCellValue('F' . $row, $student->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi');
            $sheet->setCellValue('G' . $row, $student->last_login ? Carbon::parse($student->last_login)->format('d/m/Y H:i') : '-');
            $row++;
        }

        $filename = 'rekap-mahasiswa-' . now()->format('Y-m-d') . '.xlsx';
        $path = storage_path('app/public/exports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return $filename;
    }

    public function exportSavingsToPDF(): string
    {
        $savings = Saving::with(['user', 'confirmedByUser'])
            ->orderBy('created_at')
            ->get();

        $data = [
            'savings' => $savings,
            'total' => $savings->where('status', 'approved')->sum('amount'),
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = PDF::loadView('exports.savings-pdf', $data);
        $filename = 'rekap-setoran-' . now()->format('Y-m-d') . '.pdf';
        $path = storage_path('app/public/exports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $pdf->save($path);
        return $filename;
    }

    public function exportStudentsToPDF(): string
    {
        $students = User::where('role', 'mahasiswa')
            ->withSum(['savings' => fn($q) => $q->where('status', 'approved')], 'amount')
            ->get()
            ->map(function ($student) {
                $totalSavings = $student->savings_sum_amount ?? 0;
                $progress = min(($totalSavings / config('kkl.target_amount', 1950000)) * 100, 100);

                return [
                    'nim' => $student->nim,
                    'name' => $student->name,
                    'email' => $student->email,
                    'total_savings' => $totalSavings,
                    'progress' => $progress,
                    'email_verified' => $student->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi'
                ];
            });

        $data = [
            'students' => $students,
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = PDF::loadView('exports.students-pdf', $data);
        $pdf->setPaper('a4');
        $pdf->setOption('margin-top', 20);
        $pdf->setOption('margin-bottom', 20);
        $pdf->setOption('footer-html', view('exports.footer')->render());
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('page-size', 'A4');

        $filename = 'rekap-mahasiswa-' . now()->format('Y-m-d') . '.pdf';
        $path = storage_path('app/public/exports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $pdf->save($path);
        return $filename;
    }

    public function exportFinancialToPDF(): string
    {
        $savings = Saving::with(['user', 'confirmedByUser'])
            ->where('status', 'approved')
            ->orderBy('created_at')
            ->get();

        $expenses = Expense::with(['creator', 'confirmedByUser'])
            ->where('is_confirmed_by_other', true)
            ->orderBy('created_at')
            ->get();

        $data = [
            'savings' => $savings,
            'expenses' => $expenses,
            'total_savings' => $savings->sum('amount'),
            'total_expenses' => $expenses->sum('amount'),
            'balance' => $savings->sum('amount') - $expenses->sum('amount'),
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = PDF::loadView('exports.financial-pdf', $data);
        $pdf->setPaper('a4');
        $pdf->setOption('margin-top', 20);
        $pdf->setOption('margin-bottom', 20);
        $pdf->setOption('footer-html', view('exports.footer')->render());
        $pdf->setOption('enable-smart-shrinking', true);

        $filename = 'laporan-keuangan-' . now()->format('Y-m-d') . '.pdf';
        $path = storage_path('app/public/exports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $pdf->save($path);
        return $filename;
    }

    public function exportFinancialToExcel(): string
    {
        $spreadsheet = new Spreadsheet();

        // Pemasukan Sheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pemasukan');

        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Metode');
        $sheet->setCellValue('F1', 'Dikonfirmasi Oleh');

        $savings = Saving::with(['user', 'confirmedByUser'])
            ->where('status', 'approved')
            ->orderBy('created_at')
            ->get();

        $row = 2;
        foreach ($savings as $saving) {
            $sheet->setCellValue('A' . $row, $saving->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $saving->user->nim);
            $sheet->setCellValue('C' . $row, $saving->user->name);
            $sheet->setCellValue('D' . $row, $saving->amount);
            $sheet->setCellValue('E' . $row, $saving->payment_method);
            $sheet->setCellValue('F' . $row, $saving->confirmedByUser?->name ?? '-');
            $row++;
        }

        // Pengeluaran Sheet
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Pengeluaran');

        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Deskripsi');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Dibuat Oleh');
        $sheet->setCellValue('E1', 'Dikonfirmasi Oleh');

        $expenses = Expense::with(['creator', 'confirmedByUser'])
            ->where('is_confirmed_by_other', true)
            ->orderBy('created_at')
            ->get();

        $row = 2;
        foreach ($expenses as $expense) {
            $sheet->setCellValue('A' . $row, $expense->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $expense->description);
            $sheet->setCellValue('C' . $row, $expense->amount);
            $sheet->setCellValue('D' . $row, $expense->creator->name);
            $sheet->setCellValue('E' . $row, $expense->confirmedByUser?->name ?? '-');
            $row++;
        }

        // Ringkasan Sheet
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Ringkasan');

        $totalSavings = $savings->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $balance = $totalSavings - $totalExpenses;

        $sheet->setCellValue('A1', 'Keterangan');
        $sheet->setCellValue('B1', 'Jumlah');
        $sheet->setCellValue('A2', 'Total Pemasukan');
        $sheet->setCellValue('B2', $totalSavings);
        $sheet->setCellValue('A3', 'Total Pengeluaran');
        $sheet->setCellValue('B3', $totalExpenses);
        $sheet->setCellValue('A4', 'Saldo');
        $sheet->setCellValue('B4', $balance);

        $filename = 'laporan-keuangan-' . now()->format('Y-m-d') . '.xlsx';
        $path = storage_path('app/public/exports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return $filename;
    }
}

<?php

namespace App\Filament\Actions;

use App\Models\Saving;
use App\Models\Expense;
use Filament\Actions\Action;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportFinancialReport extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'export_financial_report';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Export Laporan Keuangan')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function () {
                $spreadsheet = new Spreadsheet();

                // Savings Sheet
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle('Setoran Mahasiswa');

                $sheet->setCellValue('A1', 'Tanggal');
                $sheet->setCellValue('B1', 'Nama');
                $sheet->setCellValue('C1', 'NIM');
                $sheet->setCellValue('D1', 'Jumlah');
                $sheet->setCellValue('E1', 'Metode');
                $sheet->setCellValue('F1', 'Status');

                $savings = Saving::with('user')->orderBy('created_at')->get();
                $row = 2;

                foreach ($savings as $saving) {
                    $sheet->setCellValue('A' . $row, $saving->created_at->format('d/m/Y'));
                    $sheet->setCellValue('B' . $row, $saving->user->name);
                    $sheet->setCellValue('C' . $row, $saving->user->nim);
                    $sheet->setCellValue('D' . $row, $saving->amount);
                    $sheet->setCellValue('E' . $row, $saving->payment_method);
                    $sheet->setCellValue('F' . $row, $saving->status);
                    $row++;
                }

                // Expenses Sheet
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle('Pengeluaran');

                $sheet->setCellValue('A1', 'Tanggal');
                $sheet->setCellValue('B1', 'Deskripsi');
                $sheet->setCellValue('C1', 'Jumlah');
                $sheet->setCellValue('D1', 'Dibuat Oleh');
                $sheet->setCellValue('E1', 'Dikonfirmasi Oleh');
                $sheet->setCellValue('F1', 'Status');

                $expenses = Expense::with(['creator', 'confirmedByUser'])->orderBy('created_at')->get();
                $row = 2;

                foreach ($expenses as $expense) {
                    $sheet->setCellValue('A' . $row, $expense->created_at->format('d/m/Y'));
                    $sheet->setCellValue('B' . $row, $expense->description);
                    $sheet->setCellValue('C' . $row, $expense->amount);
                    $sheet->setCellValue('D' . $row, $expense->creator->name);
                    $sheet->setCellValue('E' . $row, $expense->confirmedByUser?->name ?? '-');
                    $sheet->setCellValue('F' . $row, $expense->is_confirmed_by_other ? 'Dikonfirmasi' : 'Pending');
                    $row++;
                }

                // Summary Sheet
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle('Ringkasan');

                $totalSavings = Saving::where('status', 'approved')->sum('amount');
                $totalExpenses = Expense::where('is_confirmed_by_other', true)->sum('amount');
                $balance = $totalSavings - $totalExpenses;

                $sheet->setCellValue('A1', 'Total Setoran');
                $sheet->setCellValue('B1', $totalSavings);
                $sheet->setCellValue('A2', 'Total Pengeluaran');
                $sheet->setCellValue('B2', $totalExpenses);
                $sheet->setCellValue('A3', 'Saldo');
                $sheet->setCellValue('B3', $balance);

                $writer = new Xlsx($spreadsheet);
                $filename = 'laporan-keuangan-' . now()->format('Y-m-d') . '.xlsx';
                $path = storage_path('app/public/' . $filename);
                $writer->save($path);

                return response()->download($path)->deleteFileAfterSend();
            });
    }
}

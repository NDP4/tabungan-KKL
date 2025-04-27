<?php

namespace App\Filament\Pages;

use App\Services\ExportService;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\Alignment;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?string $title = 'Laporan';
    protected static ?int $navigationSort = 3;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('exportSavingsExcel')
                    ->label('Export Setoran (Excel)')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $service = app(ExportService::class);
                        $filename = $service->exportSavingsToExcel();
                        return response()->download(
                            storage_path("app/public/exports/{$filename}")
                        )->deleteFileAfterSend();
                    }),
                Action::make('exportSavingsPDF')
                    ->label('Export Setoran (PDF)')
                    ->icon('heroicon-m-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $service = app(ExportService::class);
                        $filename = $service->exportSavingsToPDF();
                        return response()->download(
                            storage_path("app/public/exports/{$filename}")
                        )->deleteFileAfterSend();
                    }),
                Action::make('exportStudentsExcel')
                    ->label('Export Mahasiswa (Excel)')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('info')
                    ->action(function () {
                        $service = app(ExportService::class);
                        $filename = $service->exportStudentsToExcel();
                        return response()->download(
                            storage_path("app/public/exports/{$filename}")
                        )->deleteFileAfterSend();
                    }),
                Action::make('exportStudentsPDF')
                    ->label('Export Mahasiswa (PDF)')
                    ->icon('heroicon-m-document-arrow-down')
                    ->color('info')
                    ->action(function () {
                        $service = app(ExportService::class);
                        $filename = $service->exportStudentsToPDF();
                        return response()->download(
                            storage_path("app/public/exports/{$filename}")
                        )->deleteFileAfterSend();
                    }),
                Action::make('exportFinancialExcel')
                    ->label('Export Keuangan (Excel)')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('warning')
                    ->action(function () {
                        $service = app(ExportService::class);
                        $filename = $service->exportFinancialToExcel();
                        return response()->download(
                            storage_path("app/public/exports/{$filename}")
                        )->deleteFileAfterSend();
                    }),
                Action::make('exportFinancialPDF')
                    ->label('Export Keuangan (PDF)')
                    ->icon('heroicon-m-document-arrow-down')
                    ->color('warning')
                    ->action(function () {
                        $service = app(ExportService::class);
                        $filename = $service->exportFinancialToPDF();
                        return response()->download(
                            storage_path("app/public/exports/{$filename}")
                        )->deleteFileAfterSend();
                    }),
            ])->label('Export Data')
                ->icon('heroicon-m-document-chart-bar')
                ->color('primary')
                ->button(),
        ];
    }

    public function getView(): string
    {
        return 'filament.pages.reports';
    }
}

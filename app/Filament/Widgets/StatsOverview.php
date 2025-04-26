<?php

namespace App\Filament\Widgets;

use App\Models\Saving;
use App\Models\User;
use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalParticipants = User::count();
        $totalTarget = $totalParticipants * 1950000;
        $totalSavings = Saving::where('status', 'approved')->sum('amount');
        $totalExpenses = Expense::where('is_confirmed_by_other', true)->sum('amount');
        $currentBalance = $totalSavings - $totalExpenses;
        $remainingTarget = max(0, $totalTarget - $totalSavings);
        $pendingConfirmations = Saving::where('status', 'pending')->count();

        return [
            Stat::make('Total Peserta', number_format($totalParticipants))
                ->description('Total mahasiswa terdaftar')
                ->color('success'),
            Stat::make('Total Tabungan', 'Rp ' . number_format($totalSavings, 0, ',', '.'))
                ->description('Dari setoran yang dikonfirmasi')
                ->color('success'),
            Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalExpenses, 0, ',', '.'))
                ->description('Dari pengeluaran yang dikonfirmasi')
                ->color('danger'),
            Stat::make('Saldo Saat Ini', 'Rp ' . number_format($currentBalance, 0, ',', '.'))
                ->description('Total tabungan dikurangi pengeluaran')
                ->color($currentBalance >= 0 ? 'success' : 'danger'),
            Stat::make('Sisa Target', 'Rp ' . number_format($remainingTarget, 0, ',', '.'))
                ->description('Target: Rp ' . number_format($totalTarget, 0, ',', '.'))
                ->color('info'),
            Stat::make('Menunggu Konfirmasi', number_format($pendingConfirmations))
                ->description('Setoran yang belum dikonfirmasi')
                ->color('warning'),
        ];
    }
}

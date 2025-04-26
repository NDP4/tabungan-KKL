<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PendingExpenseConfirmations extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Expense::query()
                    ->where('is_confirmed_by_other', false)
                    ->where('created_by', '!=', Auth::id())
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
                    ->color('success')
                    ->action(fn(Expense $record) => $record->confirm(Auth::user()))
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pengeluaran')
                    ->modalDescription('Yakin ingin mengkonfirmasi pengeluaran ini?')
                    ->visible(fn(Expense $record) => $record->canConfirm(Auth::user()))
            ])
            ->paginated(false);
    }
}

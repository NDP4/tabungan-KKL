<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SavingResource\Pages;
use App\Models\Saving;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SavingResource extends Resource
{
    protected static ?string $model = Saving::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->minValue(10000),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'transfer' => 'Transfer',
                        'tunai' => 'Tunai',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('proof_file')
                    ->image()
                    ->directory('proof_files'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Menunggu Konfirmasi',
                        'approved' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(255),
                Forms\Components\Textarea::make('rejection_reason')
                    ->maxLength(255)
                    ->visible(fn($record) => $record?->status === 'rejected'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('week_number')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Konfirmasi',
                        'approved' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'transfer' => 'Transfer',
                        'tunai' => 'Tunai',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSavings::route('/'),
            'create' => Pages\CreateSaving::route('/create'),
            'edit' => Pages\EditSaving::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Filament\Support\Contracts\HasLabel;
use Filament\Resources\Concerns\HasResourcePermissions;

class ExpenseResource extends Resource
{
    // use AuthorizesRequests;
    // use HasResourcePermissions;

    protected static ?string $model = Expense::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->minValue(1000),
                Forms\Components\Toggle::make('is_confirmed_by_other')
                    ->label('Dikonfirmasi Panitia Lain')
                    ->disabled(fn($record) => !Gate::check('confirm', $record)),
                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => Auth::id()),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_confirmed_by_other')
                    ->label('Dikonfirmasi')
                    ->boolean(),
                Tables\Columns\TextColumn::make('confirmedByUser.name')
                    ->label('Dikonfirmasi Oleh')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_confirmed_by_other')
                    ->label('Status Konfirmasi'),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->action(fn(Expense $record) => $record->confirm(Auth::user() instanceof User ? Auth::user() : null))
                    ->requiresConfirmation()
                    ->visible(fn(Expense $record) => Gate::check('confirm', $record)),
                Tables\Actions\EditAction::make()->visible(fn(Expense $record) => Gate::check('update', $record)),
                Tables\Actions\DeleteAction::make()->visible(fn(Expense $record) => Gate::check('delete', $record)),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes();
    }
}

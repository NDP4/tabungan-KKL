<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'System';
    protected static ?string $modelLabel = 'Website Setting';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        $predefinedSettings = [
            'payment' => [
                'bank_name' => 'Nama Bank',
                'account_number' => 'Nomor Rekening',
                'account_holder' => 'Nama Pemilik Rekening',
            ],
            'website' => [
                'site_name' => 'Nama Website',
                'site_description' => 'Deskripsi Website',
            ],
            'contact' => [
                'admin_phone' => 'Nomor WhatsApp Admin',
                'admin_email' => 'Email Admin',
            ],
        ];

        return $form->schema([
            Select::make('group')
                ->options([
                    'payment' => 'Pembayaran',
                    'website' => 'Website',
                    'contact' => 'Kontak',
                ])
                ->required()
                ->reactive(),

            Select::make('key')
                ->options(function (callable $get) use ($predefinedSettings) {
                    $group = $get('group');
                    return $predefinedSettings[$group] ?? [];
                })
                ->required()
                ->reactive()
                ->helperText('Pilih jenis pengaturan yang ingin diubah'),

            TextInput::make('value')
                ->required()
                ->label(function (callable $get) use ($predefinedSettings) {
                    $group = $get('group');
                    $key = $get('key');
                    return $predefinedSettings[$group][$key] ?? 'Nilai';
                })
                ->helperText(function (callable $get) {
                    $key = $get('key');
                    if ($key === 'account_number') {
                        return 'Masukkan nomor rekening tanpa spasi';
                    } elseif ($key === 'admin_phone') {
                        return 'Format: 628xxxxxxxxxx (tanpa tanda + atau spasi)';
                    }
                    return '';
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->badge()
                    ->colors([
                        'warning' => 'payment',
                        'success' => 'website',
                        'info' => 'contact',
                    ]),
                TextColumn::make('key')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'payment' => 'Pembayaran',
                        'website' => 'Website',
                        'contact' => 'Kontak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}

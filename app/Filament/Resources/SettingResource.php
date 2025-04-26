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

    protected static function getPredefinedSettings(): array
    {
        return [
            'payment' => [
                'account_number' => 'Nomor Rekening',
                'account_holder' => 'Nama Pemilik Rekening',
                'bank_name' => 'Nama Bank',
            ],
            'website' => [
                'site_name' => 'Nama Aplikasi',
                'site_logo' => 'Logo Aplikasi',
                'target_amount' => 'Target Tabungan',
                'weekly_target' => 'Target Mingguan',
                'treasurer_name' => 'Nama Bendahara',
                'treasurer_signature' => 'Tanda Tangan Bendahara',
            ],
            'contact' => [
                'admin_phone' => 'No HP Admin',
                'admin_email' => 'Email Admin',
            ],
        ];
    }

    public static function form(Form $form): Form
    {
        $predefinedSettings = [
            'website' => [
                'site_name' => 'Nama Website',
                // 'site_description' => 'Deskripsi Website',
                'site_logo' => 'Logo Website',
                'favicon' => 'Favicon',
            ],
            'payment' => [
                'bank_name' => 'Nama Bank',
                'account_number' => 'Nomor Rekening',
                'account_holder' => 'Nama Pemilik Rekening',
            ],
            'treasurer' => [
                // 'treasurer_name' => 'Nama Bendahara',
                'treasurer_signature' => 'Tanda Tangan Bendahara',
            ],
            'contact' => [
                'admin_phone' => 'Nomor WhatsApp Admin',
                'admin_email' => 'Email Admin',
            ],
        ];

        return $form->schema([
            Select::make('group')
                ->options([
                    'website' => 'Website',
                    'payment' => 'Pembayaran',
                    'treasurer' => 'Bendahara',
                    'contact' => 'Kontak',
                ])
                ->required()
                ->reactive()
                ->afterStateUpdated(fn(callable $set) => $set('key', null)),

            Select::make('key')
                ->options(function (callable $get) use ($predefinedSettings) {
                    $group = $get('group');
                    return $predefinedSettings[$group] ?? [];
                })
                ->required()
                ->reactive()
                ->helperText('Pilih pengaturan yang ingin diubah'),

            FileUpload::make('value')
                ->image()
                ->directory('settings')
                ->preserveFilenames()
                ->maxSize(1024)
                ->visible(fn($get) => in_array($get('key'), ['site_logo', 'favicon', 'treasurer_signature']))
                ->helperText('Upload gambar dengan format PNG, JPG, atau SVG. Maksimal 1MB.'),

            TextInput::make('value')
                ->required()
                ->visible(fn($get) => !in_array($get('key'), ['site_logo', 'favicon', 'treasurer_signature']))
                ->label(function ($get) use ($predefinedSettings) {
                    $group = $get('group');
                    $key = $get('key');
                    return $predefinedSettings[$group][$key] ?? 'Nilai';
                })
                ->helperText(function ($get) {
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
                        'primary' => 'treasurer',
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
                        'treasurer' => 'Bendahara',
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

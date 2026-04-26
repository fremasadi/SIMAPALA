<?php

namespace App\Filament\Resources\AlatHilangLogs;

use App\Filament\Resources\AlatHilangLogs\Pages\ListAlatHilangLogs;
use App\Models\AlatHilangLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class AlatHilangLogResource extends Resource
{
    protected static ?string $model = AlatHilangLog::class;
    protected static ?string $modelLabel = 'Log Alat Hilang';
    protected static ?string $pluralModelLabel = 'Log Alat Hilang';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'Log Alat Hilang';

    protected static UnitEnum|string|null $navigationGroup = 'Log Alat';

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('alat.kode_alat')
                    ->label('Kode Alat')
                    ->searchable(),
                TextColumn::make('alat.nama_alat')
                    ->label('Nama Alat')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Dihilangkan Oleh')
                    ->searchable(),
                TextColumn::make('user.role')
                    ->label('Peran')
                    ->badge(),
                TextColumn::make('transaksi_id')
                    ->label('Transaksi #')
                    ->formatStateUsing(fn($state) => '#' . $state),
                TextColumn::make('denda')
                    ->label('Denda')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(60)
                    ->toggleable(),
                ImageColumn::make('foto_pembayaran')
                    ->label('Foto Bukti')
                    ->disk('public')
                    ->height(60)
                    ->url(fn ($record) => $record->foto_pembayaran
                        ? asset("storage/{$record->foto_pembayaran}")
                        : null)
                    ->openUrlInNewTab()
                    ->defaultImageUrl(fn () => null)
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->recordActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlatHilangLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}

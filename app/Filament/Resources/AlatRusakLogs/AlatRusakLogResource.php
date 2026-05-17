<?php

namespace App\Filament\Resources\AlatRusakLogs;

use App\Filament\Resources\AlatRusakLogs\Pages\ListAlatRusakLogs;
use App\Models\AlatRusakLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class AlatRusakLogResource extends Resource
{
    protected static ?string $model = AlatRusakLog::class;
    protected static ?string $modelLabel = 'Log Alat Rusak';
    protected static ?string $pluralModelLabel = 'Log Alat Rusak';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Log Alat Rusak';

    protected static UnitEnum|string|null $navigationGroup = 'Log Alat';

    protected static ?int $navigationSort = 4;

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
                    ->label('Dirusakkan Oleh')
                    ->searchable(),
                TextColumn::make('user.role')
                    ->label('Peran')
                    ->badge(),
                TextColumn::make('transaksi_id')
                    ->label('Transaksi #')
                    ->formatStateUsing(fn ($state) => '#' . $state),
                TextColumn::make('level_kerusakan')
                    ->label('Level Kerusakan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => AlatRusakLog::LEVEL_KERUSAKAN[$state] ?? '-')
                    ->color(fn ($state) => match ($state) {
                        'rusak_sedang' => 'warning',
                        'rusak_berat' => 'danger',
                        default => 'gray',
                    }),
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
            'index' => ListAlatRusakLogs::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}

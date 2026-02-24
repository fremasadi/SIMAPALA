<?php

namespace App\Filament\Widgets;

use App\Models\TransaksiAlat;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransaksiWidget extends BaseWidget
{
    protected static ?string $heading = 'Transaksi Terbaru';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TransaksiAlat::query()
                    ->with(['user', 'pembayaran'])
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('jenis_transaksi')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'sewa'    => 'info',
                        'pinjam'  => 'warning',
                        default   => 'gray',
                    }),

                TextColumn::make('tanggal_pinjam')
                    ->label('Tgl Pinjam')
                    ->date('d M Y'),

                TextColumn::make('tanggal_kembali')
                    ->label('Tgl Kembali')
                    ->date('d M Y'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending'     => 'warning',
                        'dibayar'     => 'success',
                        'dibatalkan'  => 'danger',
                        'expired'     => 'gray',
                        default       => 'gray',
                    }),

                TextColumn::make('pembayaran.transaction_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'settlement', 'capture' => 'success',
                        'pending'               => 'warning',
                        'cancel', 'deny', 'expire', 'failure' => 'danger',
                        default                 => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'settlement', 'capture' => 'Lunas',
                        'pending'               => 'Pending',
                        'cancel'                => 'Dibatalkan',
                        'deny'                  => 'Ditolak',
                        'expire'                => 'Kadaluarsa',
                        default                 => $state ?? '-',
                    }),

                TextColumn::make('total_biaya')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}

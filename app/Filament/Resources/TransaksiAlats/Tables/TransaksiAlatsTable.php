<?php

namespace App\Filament\Resources\TransaksiAlats\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;

class TransaksiAlatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Nama user
                TextColumn::make('user.name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('user.role')->label('Peran Pemesan')->searchable()->sortable(),
                // Jenis transaksi
                TextColumn::make('jenis_transaksi')->label('Jenis')->sortable()->badge(),

                // Tanggal Ajuan
                TextColumn::make('tanggal_ajuan')->label('Tanggal Ajuan')->date()->sortable(),

                // Tanggal Pinjam
                TextColumn::make('tanggal_pinjam')->label('Tanggal Pinjam')->date()->sortable(),

                // Tanggal Kembali
                TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->date()->sortable(),

                // Status transaksi (badge)
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'dibayar',
                        'danger' => ['expired', 'dibatalkan'],
                    ])
                    ->label('Status'),

                // Total biaya
                TextColumn::make('total_biaya')->label('Total Biaya')->money('IDR')->sortable(),

                // Jumlah alat berdasarkan relasi
                TextColumn::make('detailTransaksis_count')->label('Jumlah Alat')->counts('detailTransaksis'),

                // Status pembayaran
                BadgeColumn::make('pembayaran.transaction_status')
                    ->label('Status Pembayaran')
                    ->colors([
                        'success' => ['settlement', 'capture'],
                        'warning' => ['pending'],
                        'danger' => ['cancel', 'deny', 'failure', 'expire'],
                    ])
                    ->sortable(),
            ])

            ->filters([
                // Tambahkan filter jika perlu
            ])

            ->recordActions([
                Action::make('detail')->label('Detail')->icon('heroicon-o-eye')->modalHeading('Detail Transaksi Alat')->modalSubmitAction(false)->modalCancelActionLabel('Tutup')->modalWidth('xl')->modalContent(
                    fn($record) => view('filament.tables.transaksi-alat-modal', [
                        'record' => $record,
                    ]),
                ),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}

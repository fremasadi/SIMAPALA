<?php

namespace App\Filament\Resources\KasPembayarans\Tables;

use App\Models\DanaMasuk;
use App\Models\KasPembayaran;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class KasPembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_bayar')
                    ->label('Tanggal Bayar')
                    ->date()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable(),
                TextColumn::make('nominal')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('metode')
                    ->badge(),
                // ImageColumn::make('bukti_bayar')
                //     ->label('Bukti Bayar')
                //     ->disk('public')
                //     ->height(60)
                //     ->width(60)
                //     ->square(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'diterima' => 'success',
                        'menunggu' => 'warning',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('verified_at')
                    ->label('Diverifikasi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordUrl(null)
            ->recordActions([
                // Action::make('acc')
                //     ->label('ACC')
                //     ->icon('heroicon-o-check-circle')
                //     ->color('success')
                //     ->visible(fn (KasPembayaran $record) => $record->status === 'menunggu')
                //     ->modalHeading('Detail Pembayaran Kas')
                //     ->modalSubmitActionLabel('ACC — Terima Pembayaran')
                //     ->modalWidth('lg')
                //     ->fillForm(fn (KasPembayaran $record) => [
                //         'nama_anggota' => $record->user->name ?? '-',
                //         'tanggal_bayar' => $record->tanggal_bayar?->format('d/m/Y'),
                //         'nominal'      => 'Rp ' . number_format($record->nominal, 0, ',', '.'),
                //         'metode'       => $record->metode,
                //         'keterangan'   => $record->keterangan,
                //         'bukti_bayar'  => $record->bukti_bayar,
                //     ])
                //     ->form([
                //         TextInput::make('nama_anggota')->label('Nama Anggota')->disabled(),
                //         TextInput::make('tanggal_bayar')->label('Tanggal Bayar')->disabled(),
                //         TextInput::make('nominal')->label('Nominal')->disabled(),
                //         TextInput::make('metode')->label('Metode')->disabled(),
                //         TextInput::make('keterangan')->label('Keterangan')->disabled(),
                //         FileUpload::make('bukti_bayar')
                //             ->label('Bukti Bayar')
                //             ->disk('public')
                //             ->image()
                //             ->disabled()
                //             ->downloadable(),
                //     ])
                //     ->action(function (KasPembayaran $record) {
                //         $record->update([
                //             'status'      => 'diterima',
                //             'verified_by' => Auth::id(),
                //             'verified_at' => now(),
                //         ]);

                //         // Update status kas bulanan menjadi lunas
                //         $record->kasBulanan?->update(['status' => 'lunas']);

                //         // Insert dana masuk kas
                //         $sudahAda = DanaMasuk::where('sumber_type', KasPembayaran::class)
                //             ->where('sumber_id', $record->id)
                //             ->where('jenis', 'kas')
                //             ->exists();

                //         if (!$sudahAda) {
                //             DanaMasuk::create([
                //                 'jenis'       => 'kas',
                //                 'nominal'     => $record->nominal,
                //                 'status'      => 'approved',
                //                 'keterangan'  => "Kas bulanan — {$record->user->name}",
                //                 'tanggal'     => now()->toDateString(),
                //                 'user_id'     => $record->user_id,
                //                 'sumber_type' => KasPembayaran::class,
                //                 'sumber_id'   => $record->id,
                //             ]);
                //         }
                //     }),

                // Action::make('tolak')
                //     ->label('Tolak')
                //     ->icon('heroicon-o-x-circle')
                //     ->color('danger')
                //     ->visible(fn (KasPembayaran $record) => $record->status === 'menunggu')
                //     ->requiresConfirmation()
                //     ->modalHeading('Tolak Pembayaran Kas')
                //     ->modalDescription('Tandai pembayaran kas ini sebagai ditolak?')
                //     ->action(fn (KasPembayaran $record) => $record->update([
                //         'status'      => 'ditolak',
                //         'verified_by' => Auth::id(),
                //         'verified_at' => now(),
                //     ])),
            ],
            );
    }
}

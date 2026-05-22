<?php

namespace App\Filament\Resources\TransaksiAlats\Tables;

use App\Filament\Resources\TransaksiAlats\TransaksiAlatResource;
use App\Models\AlatHilangLog;
use App\Models\AlatRusakLog;
use App\Models\DanaMasuk;
use App\Models\DetailTransaksi;
use App\Models\TransaksiAlat;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
                TextColumn::make('jenis_jaminan')->label('Jenis Jaminan')->sortable()->searchable(),
                ImageColumn::make('foto_jaminan')
                    ->label('Foto Jaminan')
                    ->disk('public')
                    ->rounded()
                    ->height(80)
                    ->width(80),

                // Tanggal Ajuan
                TextColumn::make('tanggal_ajuan')->label('Tanggal Ajuan')->date()->sortable(),

                // Tanggal Pinjam
                TextColumn::make('tanggal_pinjam')->label('Tanggal Pinjam')->date()->sortable(),

                // Tanggal Kembali
                TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->date()->sortable(),

                // Status transaksi (badge)
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending'     => 'warning',
                        'dibayar'     => 'success',
                        'expired', 'dibatalkan' => 'danger',
                        default       => 'gray',
                    })
                    ->label('Status'),

                // Total biaya
                TextColumn::make('total_biaya')->label('Total Biaya')->money('IDR')->sortable(),

                // Jumlah alat berdasarkan relasi
                // TextColumn::make('detailTransaksis_count')->label('Jumlah Alat')->counts('detailTransaksis'),

                // Status pembayaran
                TextColumn::make('pembayaran.transaction_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn ($state, TransaksiAlat $record) => match ($state) {
                        'settlement', 'capture' => (float) $record->total_biaya === 0.0
                            ? 'Lunas (Anggota)'
                            : 'Lunas',
                        'pending' => 'Menunggu',
                        'cancel' => 'Dibatalkan',
                        'deny' => 'Ditolak',
                        'failure' => 'Gagal',
                        'expire' => 'Kadaluarsa',
                        default => ucfirst($state),
                    })
                    ->color(fn ($state) => match ($state) {
                        'settlement', 'capture' => 'success',
                        'pending'               => 'warning',
                        'cancel', 'deny', 'failure', 'expire' => 'danger',
                        default                 => 'gray',
                    })
                    ->sortable(),
            ])

            ->defaultSort('created_at', 'desc')
            ->filters([])

            ->recordActions([
                Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => TransaksiAlatResource::getUrl('view', ['record' => $record])),

                Action::make('acc')
                    ->label('ACC')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (TransaksiAlat $record) => $record->status === 'menunggu')
                    ->requiresConfirmation()
                    ->modalHeading('ACC Peminjaman')
                    ->modalDescription('Setujui pengajuan peminjaman alat ini?')
                    ->action(fn (TransaksiAlat $record) => $record->update(['status' => 'disetujui'])),

                Action::make('dipinjam')
                    ->label('Pinjam')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('info')
                    ->visible(fn (TransaksiAlat $record) => $record->status === 'disetujui')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Peminjaman')
                    ->modalDescription('Tandai transaksi ini sebagai sedang dipinjam?')
                    ->action(function (TransaksiAlat $record) {
                        $record->loadMissing('detailTransaksis.alat');

                        foreach ($record->detailTransaksis as $detail) {
                            $detail->alat?->update(['status' => 'dipinjam']);
                        }

                        $record->update(['status' => 'dipinjam']);
                    }),

                Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->visible(fn (TransaksiAlat $record) => $record->status === 'dipinjam')
                    ->fillForm(fn (TransaksiAlat $record) => [
                        'hari_telat' => $record->tanggal_kembali && $record->tanggal_kembali->isPast()
                            ? (int) $record->tanggal_kembali->diffInDays(now())
                            : 0,
                        'total_denda_telat' => number_format(
                            ($record->tanggal_kembali && $record->tanggal_kembali->isPast()
                                ? (int) $record->tanggal_kembali->diffInDays(now())
                                : 0) * TransaksiAlat::DENDA_TELAT_PER_HARI,
                            0, ',', '.'
                        ),
                        'detail_items' => $record->detailTransaksis->map(fn ($d) => [
                            'id'              => $d->id,
                            'alat_nama'       => $d->alat->nama_alat ?? '-',
                            'kode_alat'       => $d->alat->kode_alat ?? '-',
                            'harga_alat'      => $d->alat->harga_alat ?? 0,
                            'kondisi_kembali' => $d->kondisi_kembali ?? 'baik',
                            'level_kerusakan' => $d->level_kerusakan,
                            'denda_rusak'     => $d->denda_rusak ?? 0,
                            'keterangan'      => $d->keterangan,
                        ])->toArray(),
                    ])
                    ->form([
                        Section::make('Informasi Keterlambatan')
                            ->columns(2)
                            ->schema([
                                TextInput::make('hari_telat')
                                    ->label('Hari Terlambat')
                                    ->disabled()
                                    ->suffix('hari'),
                                TextInput::make('total_denda_telat')
                                    ->label('Total Denda Terlambat')
                                    ->disabled()
                                    ->prefix('Rp'),
                            ]),

                        Section::make('Kondisi Alat')
                            ->schema([
                                Repeater::make('detail_items')
                                    ->label('')
                                    ->addable(false)
                                    ->deletable(false)
                                    ->columns(4)
                                    ->schema([
                                        Hidden::make('id'),
                                        Hidden::make('harga_alat'),
                                        TextInput::make('kode_alat')
                                            ->label('Kode Alat')
                                            ->disabled(),
                                        TextInput::make('alat_nama')
                                            ->label('Nama Alat')
                                            ->disabled(),
                                        Select::make('kondisi_kembali')
                                            ->label('Kondisi')
                                            ->options([
                                                'baik'   => 'Baik',
                                                'rusak'  => 'Rusak',
                                                'hilang' => 'Hilang',
                                            ])
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                if ($state === 'hilang') {
                                                    $set('denda_rusak', (float) $get('harga_alat'));
                                                    $set('level_kerusakan', null);
                                                } elseif ($state === 'baik') {
                                                    $set('denda_rusak', 0);
                                                    $set('level_kerusakan', null);
                                                } elseif ($state === 'rusak') {
                                                    $set('denda_rusak', 0);
                                                }
                                            }),
                                        Select::make('level_kerusakan')
                                            ->label('Level Kerusakan')
                                            ->options(AlatRusakLog::LEVEL_KERUSAKAN)
                                            ->visible(fn ($get) => $get('kondisi_kembali') === 'rusak')
                                            ->required(fn ($get) => $get('kondisi_kembali') === 'rusak')
                                            ->live()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                if ($state === 'rusak_berat') {
                                                    $set('denda_rusak', (float) $get('harga_alat'));
                                                } elseif ($state === 'rusak_sedang') {
                                                    $set('denda_rusak', 0);
                                                }
                                            })
                                            ->dehydrated(),
                                        TextInput::make('denda_rusak')
                                            ->label('Denda Rusak/Hilang (Rp)')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0)
                                            ->disabled(fn ($get) => $get('kondisi_kembali') === 'hilang'
                                                || $get('level_kerusakan') === 'rusak_berat')
                                            ->dehydrated(),
                                        Textarea::make('keterangan')
                                            ->label('Catatan Kerusakan')
                                            ->placeholder('Contoh: robek 5 cm di bagian atas')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->visible(fn ($get) => $get('kondisi_kembali') === 'rusak')
                                            ->required(fn ($get) => $get('kondisi_kembali') === 'rusak')
                                            ->dehydrated(),
                                    ]),
                            ]),

                        Section::make('Bukti Pembayaran Denda')
                            ->schema([
                                FileUpload::make('foto_pembayaran')
                                    ->label('Foto Bukti Pembayaran')
                                    ->helperText('Dipakai bersama untuk denda alat rusak dan hilang pada transaksi ini.')
                                    ->image()
                                    ->disk('public')
                                    ->directory('pengembalian-pembayaran')
                                    ->acceptedFileTypes(['image/*'])
                                    ->imageEditor()
                                    ->columnSpanFull()
                                    ->visible(fn ($get) => collect($get('detail_items') ?? [])
                                        ->contains(fn ($item) => in_array($item['kondisi_kembali'] ?? null, ['rusak', 'hilang'], true)))
                                    ->required(fn ($get) => collect($get('detail_items') ?? [])
                                        ->contains(fn ($item) => in_array($item['kondisi_kembali'] ?? null, ['rusak', 'hilang'], true)
                                            && (float) ($item['denda_rusak'] ?? 0) > 0))
                                    ->nullable(),
                            ])
                            ->visible(fn ($get) => collect($get('detail_items') ?? [])
                                ->contains(fn ($item) => in_array($item['kondisi_kembali'] ?? null, ['rusak', 'hilang'], true))),
                    ])
                    ->action(function (TransaksiAlat $record, array $data) {
                        $hariTelat = $record->tanggal_kembali && $record->tanggal_kembali->isPast()
                            ? (int) $record->tanggal_kembali->diffInDays(now())
                            : 0;
                        $dendaTelat = $hariTelat * TransaksiAlat::DENDA_TELAT_PER_HARI;
                        $fotoPembayaran = $data['foto_pembayaran'] ?? null;
                        $totalRusak = 0;
                        $totalHilang = 0;

                        foreach ($data['detail_items'] as $item) {
                            $dendaRusak = (float) ($item['denda_rusak'] ?? 0);

                            $detail = DetailTransaksi::find($item['id']);
                            $detail?->update([
                                'kondisi_kembali' => $item['kondisi_kembali'],
                                'level_kerusakan' => $item['kondisi_kembali'] === 'rusak'
                                    ? ($item['level_kerusakan'] ?? null)
                                    : null,
                                'denda_rusak'     => $dendaRusak,
                                'denda_telat'     => $dendaTelat,
                                'keterangan'      => $item['keterangan'] ?? null,
                            ]);

                            if ($detail && $detail->alat) {
                                if ($item['kondisi_kembali'] === 'hilang') {
                                    // Update status alat menjadi hilang
                                    $detail->alat->update(['status' => 'hilang']);

                                    // Tulis log alat hilang
                                    AlatHilangLog::create([
                                        'alat_id'          => $detail->alat_id,
                                        'user_id'          => $record->user_id,
                                        'transaksi_id'     => $record->id,
                                        'denda'            => $dendaRusak,
                                        'keterangan'       => "Alat hilang saat pengembalian - Transaksi #{$record->id}",
                                        'foto_pembayaran'  => $fotoPembayaran,
                                    ]);
                                } elseif ($item['kondisi_kembali'] === 'rusak') {
                                    $detail->alat->update(['status' => 'rusak']);

                                    AlatRusakLog::create([
                                        'alat_id'              => $detail->alat_id,
                                        'user_id'              => $record->user_id,
                                        'transaksi_id'         => $record->id,
                                        'detail_transaksi_id'  => $detail->id,
                                        'level_kerusakan'       => $item['level_kerusakan'] ?? null,
                                        'denda'                => $dendaRusak,
                                        'keterangan'           => $item['keterangan'] ?? "Alat rusak saat pengembalian - Transaksi #{$record->id}",
                                        'foto_pembayaran'      => $fotoPembayaran,
                                    ]);
                                } else {
                                    $detail->alat->update(['status' => 'tersedia']);
                                }
                            }

                            if (($item['kondisi_kembali'] ?? null) === 'hilang') {
                                $totalHilang += $dendaRusak;
                            } elseif (($item['kondisi_kembali'] ?? null) === 'rusak') {
                                $totalRusak += $dendaRusak;
                            }
                        }

                        // Insert dana masuk denda telat (satu entri per transaksi)
                        if ($dendaTelat > 0) {
                            DanaMasuk::create([
                                'jenis'       => 'denda_telat',
                                'nominal'     => $dendaTelat,
                                'status'      => 'approved',
                                'keterangan'  => "Denda telat {$hariTelat} hari - Transaksi #{$record->id}",
                                'tanggal'     => now()->toDateString(),
                                'user_id'     => $record->user_id,
                                'sumber_type' => TransaksiAlat::class,
                                'sumber_id'   => $record->id,
                            ]);
                        }

                        // Insert dana masuk denda rusak (satu entri total per transaksi)
                        if ($totalRusak > 0) {
                            DanaMasuk::create([
                                'jenis'       => 'denda_rusak',
                                'nominal'     => $totalRusak,
                                'status'      => 'approved',
                                'keterangan'  => "Denda rusak alat - Transaksi #{$record->id}",
                                'tanggal'     => now()->toDateString(),
                                'user_id'     => $record->user_id,
                                'sumber_type' => TransaksiAlat::class,
                                'sumber_id'   => $record->id,
                            ]);
                        }

                        if ($totalHilang > 0) {
                            DanaMasuk::create([
                                'jenis'       => 'denda_hilang',
                                'nominal'     => $totalHilang,
                                'status'      => 'approved',
                                'keterangan'  => "Denda alat hilang - Transaksi #{$record->id}",
                                'tanggal'     => now()->toDateString(),
                                'user_id'     => $record->user_id,
                                'sumber_type' => TransaksiAlat::class,
                                'sumber_id'   => $record->id,
                            ]);
                        }

                        $record->update(['status' => 'dikembalikan']);
                    }),
            ]);
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Alat;
use App\Models\Anggota;
use App\Models\KasPembayaran;
use App\Models\Pembayaran;
use App\Models\TransaksiAlat;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalAlat       = Alat::count();
        $alatTersedia    = Alat::where('status', 'tersedia')->count();
        $alatDipinjam    = Alat::where('status', 'dipinjam')->count();

        $totalUser       = User::count();
        $totalAnggota    = Anggota::where('status_keanggotaan', 'aktif')->count();

        $transaksBulanIni = TransaksiAlat::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pendapatanBulanIni = Pembayaran::whereIn('transaction_status', ['settlement', 'capture'])
            ->whereMonth('settlement_time', now()->month)
            ->whereYear('settlement_time', now()->year)
            ->sum('gross_amount');

        $kasTerkumpul = KasPembayaran::where('status', 'diterima')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('nominal');

        return [
            Stat::make('Total Alat', $totalAlat)
                ->description("{$alatTersedia} tersedia · {$alatDipinjam} dipinjam")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-archive-box'),

            Stat::make('Total Pengguna', $totalUser)
                ->description("{$totalAnggota} anggota aktif")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->icon('heroicon-o-users'),

            Stat::make('Transaksi Bulan Ini', $transaksBulanIni)
                ->description(now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning')
                ->icon('heroicon-o-clipboard-document-list'),

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($pendapatanBulanIni, 0, ',', '.'))
                ->description('Pembayaran settlement')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Kas Terkumpul Bulan Ini', 'Rp ' . number_format($kasTerkumpul, 0, ',', '.'))
                ->description('Total kas diterima')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('primary')
                ->icon('heroicon-o-wallet'),
        ];
    }
}

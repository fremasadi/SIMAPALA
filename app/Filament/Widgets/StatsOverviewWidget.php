<?php

namespace App\Filament\Widgets;

use App\Models\Alat;
use App\Models\Anggota;
use App\Models\DanaMasuk;
use App\Models\KasPembayaran;
use App\Models\TransaksiAlat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalAlat    = Alat::count();
        $alatTersedia = Alat::where('status', 'tersedia')->count();
        $alatDipinjam = Alat::where('status', 'dipinjam')->count();

        $totalAnggota = Anggota::where('status_keanggotaan', 'aktif')->count();

        $transaksBulanIni = TransaksiAlat::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $kasPending = KasPembayaran::where('status', 'menunggu')->count();

        $sumbanganPending = DanaMasuk::where('status', 'pending')
            ->where('jenis', 'sumbangan')
            ->count();

        return [
            Stat::make('Total Alat', $totalAlat)
                ->description("{$alatTersedia} tersedia · {$alatDipinjam} dipinjam")
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->icon('heroicon-o-archive-box'),

            Stat::make('Anggota Aktif', $totalAnggota)
                ->description('Terdaftar & aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->icon('heroicon-o-users'),

            Stat::make('Transaksi Bulan Ini', $transaksBulanIni)
                ->description(now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning')
                ->icon('heroicon-o-clipboard-document-list'),

            Stat::make('Kas Menunggu Verifikasi', $kasPending)
                ->description('Pembayaran kas pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color($kasPending > 0 ? 'warning' : 'success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Sumbangan Pending', $sumbanganPending)
                ->description('Menunggu approval admin')
                ->descriptionIcon('heroicon-m-heart')
                ->color($sumbanganPending > 0 ? 'warning' : 'success')
                ->icon('heroicon-o-heart'),
        ];
    }
}

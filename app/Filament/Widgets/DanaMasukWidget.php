<?php

namespace App\Filament\Widgets;

use App\Models\DanaMasuk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DanaMasukWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    protected ?string $heading = 'Ringkasan Dana Masuk — ' ;

    public function mount(): void
    {
        $this->heading = 'Ringkasan Dana Masuk — ' . now()->translatedFormat('F Y');
    }

    protected function getStats(): array
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $base = fn () => DanaMasuk::where('status', 'approved')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $total      = $base()->sum('nominal');
        $penyewaan  = $base()->where('jenis', 'penyewaan')->sum('nominal');
        $kas        = $base()->where('jenis', 'kas')->sum('nominal');
        $dendaTelat = $base()->where('jenis', 'denda_telat')->sum('nominal');
        $dendaRusak = $base()->where('jenis', 'denda_rusak')->sum('nominal');
        $sumbangan  = $base()->where('jenis', 'sumbangan')->sum('nominal');
        $danaKampus = $base()->where('jenis', 'dana_kampus')->sum('nominal');

        $fmt = fn ($val) => 'Rp ' . number_format((float) $val, 0, ',', '.');

        return [
            Stat::make('Total Dana Masuk', $fmt($total))
                ->description('Semua jenis · bulan ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->icon('heroicon-o-wallet'),

            Stat::make('Penyewaan Alat', $fmt($penyewaan))
                ->description('Pembayaran Berhasil')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('info')
                ->icon('heroicon-o-archive-box'),

            Stat::make('Kas Anggota', $fmt($kas))
                ->description('Kas bulanan diterima')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('primary')
                ->icon('heroicon-o-building-library'),

            Stat::make('Denda Telat', $fmt($dendaTelat))
                ->description('Denda keterlambatan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Denda Rusak', $fmt($dendaRusak))
                ->description('Denda kerusakan alat')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('danger')
                ->icon('heroicon-o-wrench-screwdriver'),

            Stat::make('Sumbangan & Dana Kampus', $fmt($sumbangan + $danaKampus))
                ->description('Sumbangan + Dana kampus')
                ->descriptionIcon('heroicon-m-heart')
                ->color('success')
                ->icon('heroicon-o-heart'),
        ];
    }
}

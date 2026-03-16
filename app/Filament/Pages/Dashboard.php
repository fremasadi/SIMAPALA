<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AlatStatusWidget;
use App\Filament\Widgets\DanaMasukWidget;
use App\Filament\Widgets\LatestTransaksiWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\TransaksiChartWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title           = 'Dashboard';
    protected static ?int $navigationSort     = -1;

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,   // Row 1 — Stats operasional
            DanaMasukWidget::class,       // Row 3 — Ringkasan keuangan per jenis
            TransaksiChartWidget::class,  // Row 2a — Chart transaksi (span=2)
            AlatStatusWidget::class,      // Row 2b — Donut status alat (span=1)
            LatestTransaksiWidget::class, // Row 4 — Tabel transaksi terbaru
        ];
    }

    public function getColumns(): int | array
    {
        return 3; // 3 kolom — TransaksiChart span=2, AlatStatus span=1 pas di Row 2
    }
}

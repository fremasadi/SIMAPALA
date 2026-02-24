<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AlatStatusWidget;
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
            StatsOverviewWidget::class,
            TransaksiChartWidget::class,
            AlatStatusWidget::class,
            LatestTransaksiWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'sm'  => 1,
            'md'  => 2,
            'xl'  => 3,
        ];
    }
}

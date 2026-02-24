<?php

namespace App\Filament\Widgets;

use App\Models\Alat;
use Filament\Widgets\ChartWidget;

class AlatStatusWidget extends ChartWidget
{
    protected ?string $heading = 'Status Alat';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $tersedia = Alat::where('status', 'tersedia')->count();
        $dipinjam = Alat::where('status', 'dipinjam')->count();
        $rusak    = Alat::where('status', 'rusak')->count();
        $hilang   = Alat::where('status', 'hilang')->count();

        return [
            'datasets' => [
                [
                    'data'            => [$tersedia, $dipinjam, $rusak, $hilang],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',   // tersedia - green
                        'rgba(234, 179, 8, 0.8)',   // dipinjam - yellow
                        'rgba(239, 68, 68, 0.8)',   // rusak    - red
                        'rgba(107, 114, 128, 0.8)', // hilang   - gray
                    ],
                    'borderColor' => [
                        'rgba(21, 128, 61, 1)',
                        'rgba(161, 98, 7, 1)',
                        'rgba(185, 28, 28, 1)',
                        'rgba(55, 65, 81, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
        ];
    }
}

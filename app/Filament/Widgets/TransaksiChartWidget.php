<?php

namespace App\Filament\Widgets;

use App\Models\TransaksiAlat;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TransaksiChartWidget extends ChartWidget
{
    protected ?string $heading = 'Transaksi per Bulan';
    protected static ?int $sort = 2;
    // Row 2: berdampingan dengan AlatStatusWidget (span=1)
    protected int | string | array $columnSpan = 2;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        $labels = $months->map(fn ($m) => $m->translatedFormat('M Y'))->toArray();

        $transaksi = $months->map(fn ($m) => TransaksiAlat::whereMonth('created_at', $m->month)
            ->whereYear('created_at', $m->year)
            ->count()
        )->toArray();

        $pendapatan = $months->map(fn ($m) => \App\Models\Pembayaran::whereIn('transaction_status', ['settlement', 'capture'])
            ->whereMonth('settlement_time', $m->month)
            ->whereYear('settlement_time', $m->year)
            ->sum('gross_amount') / 1000 // dalam ribuan rupiah
        )->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Jumlah Transaksi',
                    'data'            => $transaksi,
                    'backgroundColor' => 'rgba(234, 179, 8, 0.7)',
                    'borderColor'     => 'rgba(202, 138, 4, 1)',
                    'borderWidth'     => 2,
                    'yAxisID'         => 'y',
                ],
                [
                    'label'           => 'Pendapatan (Rp ribu)',
                    'data'            => $pendapatan,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.4)',
                    'borderColor'     => 'rgba(21, 128, 61, 1)',
                    'borderWidth'     => 2,
                    'yAxisID'         => 'y1',
                    'type'            => 'line',
                    'fill'            => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y'  => ['position' => 'left',  'title' => ['display' => true, 'text' => 'Jumlah Transaksi']],
                'y1' => ['position' => 'right', 'title' => ['display' => true, 'text' => 'Pendapatan (Rp ribu)'], 'grid' => ['drawOnChartArea' => false]],
            ],
        ];
    }
}

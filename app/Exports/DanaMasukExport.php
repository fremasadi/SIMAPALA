<?php

namespace App\Exports;

use App\Models\DanaMasuk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DanaMasukExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    public function __construct(
        protected array $filters = [],
    ) {}

    public function collection(): Collection
    {
        return DanaMasuk::query()
            ->with('user')
            ->when($this->filters['jenis']['value'] ?? null, fn ($q, $value) => $q->where('jenis', $value))
            ->when($this->filters['status']['value'] ?? null, fn ($q, $value) => $q->where('status', $value))
            ->when($this->filters['tanggal']['dari'] ?? null, fn ($q, $value) => $q->whereDate('tanggal', '>=', $value))
            ->when($this->filters['tanggal']['sampai'] ?? null, fn ($q, $value) => $q->whereDate('tanggal', '<=', $value))
            ->orderBy('tanggal', 'desc')
            ->get()
            ->values()
            ->map(fn (DanaMasuk $row, int $index) => [
                'No' => $index + 1,
                'Jenis' => DanaMasuk::JENIS[$row->jenis] ?? ucfirst($row->jenis),
                'Nominal (Rp)' => $row->nominal,
                'Keterangan' => $row->keterangan,
                'Tanggal' => $row->tanggal?->format('d/m/Y'),
                'Status' => match ($row->status) {
                    'approved' => 'Diterima',
                    'pending' => 'Menunggu',
                    default => ucfirst($row->status),
                },
                'Diinput Oleh' => $row->user?->name,
            ]);
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis',
            'Nominal (Rp)',
            'Keterangan',
            'Tanggal',
            'Status',
            'Diinput Oleh',
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\DanaKeluar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DanaKeluarExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    public function __construct(
        protected array $filters = [],
    ) {}

    public function collection(): Collection
    {
        return DanaKeluar::query()
            ->with('user')
            ->when($this->filters['jenis']['value'] ?? null, fn ($q, $value) => $q->where('jenis', $value))
            ->when($this->filters['tanggal']['dari'] ?? null, fn ($q, $value) => $q->whereDate('tanggal', '>=', $value))
            ->when($this->filters['tanggal']['sampai'] ?? null, fn ($q, $value) => $q->whereDate('tanggal', '<=', $value))
            ->orderBy('tanggal', 'desc')
            ->get()
            ->values()
            ->map(fn (DanaKeluar $row, int $index) => [
                'No' => $index + 1,
                'Jenis' => DanaKeluar::JENIS[$row->jenis] ?? ucfirst($row->jenis),
                'Nominal (Rp)' => $row->nominal,
                'Keterangan' => $row->keterangan,
                'Tanggal' => $row->tanggal?->format('d/m/Y'),
                'Diinput Oleh' => $row->user?->name,
                'Sumber' => $row->sumber_type ? class_basename($row->sumber_type) : '-',
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
            'Diinput Oleh',
            'Sumber',
        ];
    }
}

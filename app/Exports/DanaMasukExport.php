<?php

namespace App\Exports;

use App\Models\DanaMasuk;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\Builder;

class DanaMasukExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(protected array $filters = []) {}

    public function query(): Builder
    {
        return DanaMasuk::query()
            ->with('user')
            ->when($this->filters['jenis'] ?? null, fn ($q, $v) => $q->where('jenis', $v))
            ->when($this->filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($this->filters['dari'] ?? null, fn ($q, $v) => $q->whereDate('tanggal', '>=', $v))
            ->when($this->filters['sampai'] ?? null, fn ($q, $v) => $q->whereDate('tanggal', '<=', $v))
            ->orderBy('tanggal', 'desc');
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

    protected int $row = 1;

    public function map($record): array
    {
        return [
            $this->row++,
            DanaMasuk::JENIS[$record->jenis] ?? ucfirst($record->jenis),
            $record->nominal,
            $record->keterangan,
            $record->tanggal?->format('d/m/Y'),
            ucfirst($record->status),
            $record->user?->name,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

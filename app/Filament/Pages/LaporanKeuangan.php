<?php

namespace App\Filament\Pages;

use App\Models\DanaKeluar;
use App\Models\DanaMasuk;
use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class LaporanKeuangan extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static UnitEnum|string|null $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static ?string $title = 'Laporan Keuangan';
    protected string $view = 'filament.pages.laporan-keuangan';

    public ?string $dari = null;
    public ?string $sampai = null;

    public function mount(): void
    {
        $this->dari = now()->startOfMonth()->toDateString();
        $this->sampai = now()->endOfMonth()->toDateString();
    }

    public function getTotalPemasukanProperty(): float
    {
        return (float) $this->danaMasukQuery()->sum('nominal');
    }

    public function getTotalPengeluaranProperty(): float
    {
        return (float) $this->danaKeluarQuery()->sum('nominal');
    }

    public function getSaldoProperty(): float
    {
        return $this->totalPemasukan - $this->totalPengeluaran;
    }

    public function getJumlahTransaksiProperty(): int
    {
        return $this->danaMasukQuery()->count() + $this->danaKeluarQuery()->count();
    }

    public function getDanaMasuksProperty()
    {
        return $this->danaMasukQuery()
            ->with('user')
            ->orderByDesc('tanggal')
            ->latest('id')
            ->get();
    }

    public function getDanaKeluarsProperty()
    {
        return $this->danaKeluarQuery()
            ->with('user')
            ->orderByDesc('tanggal')
            ->latest('id')
            ->get();
    }

    public function getRingkasanPemasukanProperty()
    {
        return $this->danaMasukQuery()
            ->selectRaw('jenis, SUM(nominal) as total')
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->get();
    }

    public function getRingkasanPengeluaranProperty()
    {
        return $this->danaKeluarQuery()
            ->selectRaw('jenis, SUM(nominal) as total')
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->get();
    }

    public function getArusKasProperty()
    {
        $pemasukan = $this->danaMasuks->map(fn (DanaMasuk $row) => [
            'tanggal' => $row->tanggal,
            'tipe' => 'masuk',
            'jenis' => $row->jenis_label,
            'keterangan' => $row->keterangan,
            'nominal' => (float) $row->nominal,
        ]);

        $pengeluaran = $this->danaKeluars->map(fn (DanaKeluar $row) => [
            'tanggal' => $row->tanggal,
            'tipe' => 'keluar',
            'jenis' => $row->jenis_label,
            'keterangan' => $row->keterangan,
            'nominal' => (float) $row->nominal,
        ]);

        return $pemasukan
            ->concat($pengeluaran)
            ->sortByDesc(fn (array $row) => $row['tanggal']?->format('Y-m-d') . '|' . $row['tipe'])
            ->values();
    }

    private function danaMasukQuery()
    {
        return DanaMasuk::query()
            ->where('status', 'approved')
            ->when($this->dari, fn ($query) => $query->whereDate('tanggal', '>=', $this->dari))
            ->when($this->sampai, fn ($query) => $query->whereDate('tanggal', '<=', $this->sampai));
    }

    private function danaKeluarQuery()
    {
        return DanaKeluar::query()
            ->when($this->dari, fn ($query) => $query->whereDate('tanggal', '>=', $this->dari))
            ->when($this->sampai, fn ($query) => $query->whereDate('tanggal', '<=', $this->sampai));
    }
}

<?php

namespace App\Console\Commands;

use App\Models\DanaMasuk;
use App\Models\KasBulanan;
use App\Models\KasPembayaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearOldKasPembayaran extends Command
{
    protected $signature = 'simapala:clear-old-kas-pembayaran
        {--force : Jalankan tanpa konfirmasi}
        {--all : Hapus semua pembayaran kas, termasuk yang sudah punya order Midtrans}';

    protected $description = 'Hapus data pembayaran kas lama dari form manual beserta dana masuk terkait.';

    public function handle(): int
    {
        $query = KasPembayaran::query();

        if (! $this->option('all')) {
            $query->whereNull('order_id');
        }

        $paymentIds = $query->pluck('id');
        $kasBulananIds = KasPembayaran::whereIn('id', $paymentIds)
            ->pluck('kas_bulanan_id')
            ->filter()
            ->unique()
            ->values();

        $danaMasukCount = DanaMasuk::where('sumber_type', KasPembayaran::class)
            ->whereIn('sumber_id', $paymentIds)
            ->count();

        $label = $this->option('all')
            ? 'semua pembayaran kas'
            : 'pembayaran kas lama dari form manual (order_id kosong)';

        $this->line("Target: {$label}");
        $this->line("kas_pembayarans: {$paymentIds->count()} data");
        $this->line("dana_masuks terkait: {$danaMasukCount} data");
        $this->line("kas_bulanans terdampak: {$kasBulananIds->count()} data");

        if ($paymentIds->isEmpty()) {
            $this->info('Tidak ada data yang perlu dihapus.');

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm('Lanjut hapus data tersebut?')) {
            $this->warn('Dibatalkan.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($paymentIds, $kasBulananIds) {
            DanaMasuk::where('sumber_type', KasPembayaran::class)
                ->whereIn('sumber_id', $paymentIds)
                ->delete();

            KasPembayaran::whereIn('id', $paymentIds)->delete();

            KasBulanan::whereIn('id', $kasBulananIds)
                ->get()
                ->each(fn (KasBulanan $kasBulanan) => $kasBulanan->updateStatus());
        });

        $this->info('Data pembayaran kas berhasil dibersihkan.');

        return self::SUCCESS;
    }
}

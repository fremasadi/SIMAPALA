<?php

namespace App\Console\Commands;

use App\Models\DanaMasuk;
use App\Models\KasBulanan;
use App\Models\KasPembayaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateKasBulanan extends Command
{
    protected $signature = 'kas:generate-bulanan
                            {--dari= : Dari bulan (format: YYYY-MM), default: bulan mulai tiap anggota}
                            {--sampai= : Sampai bulan (format: YYYY-MM), default: bulan saat ini}
                            {--nominal=10000 : Nominal kas per bulan}
                            {--reset : Hapus seluruh data kas sebelum generate ulang}
                            {--reset-only : Hanya reset data kas tanpa generate ulang}
                            {--force : Jalankan tanpa konfirmasi saat reset}';

    protected $description = 'Generate kas bulanan berdasarkan tanggal anggota dibuat, dengan opsi reset data untuk development.';

    public function handle(): int
    {
        $shouldReset = $this->option('reset') || $this->option('reset-only');

        if ($shouldReset && ! $this->resetKasData()) {
            return self::SUCCESS;
        }

        if ($this->option('reset-only')) {
            $this->info('Reset data kas selesai. Generate dilewati karena --reset-only digunakan.');

            return self::SUCCESS;
        }

        $anggota = User::query()
            ->with('anggota')
            ->where('role', 'anggota')
            ->orderBy('name')
            ->get();

        if ($anggota->isEmpty()) {
            $this->warn('Tidak ada user dengan role anggota.');

            return self::SUCCESS;
        }

        try {
            $batasDari = $this->parseMonthOption('dari');
            $sampai = $this->parseMonthOption('sampai') ?? now()->startOfMonth();
        } catch (\Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $nominal = (int) $this->option('nominal');

        if ($nominal <= 0) {
            $this->error('Nominal kas harus lebih besar dari 0.');

            return self::FAILURE;
        }

        $this->info("Generate kas sampai {$sampai->translatedFormat('F Y')}");
        $this->line('Nominal per bulan: Rp ' . number_format($nominal, 0, ',', '.'));
        if ($batasDari) {
            $this->line("Batas awal manual: {$batasDari->translatedFormat('F Y')}");
        }
        $this->newLine();

        $totalCreated = 0;
        $totalSkipped = 0;
        $totalTidakPerluGenerate = 0;

        foreach ($anggota as $user) {
            $mulai = $this->resolveStartMonth($user, $batasDari);

            if ($mulai->gt($sampai)) {
                $totalTidakPerluGenerate++;
                $this->line("- {$user->name}: tidak ada bulan yang perlu dibuat");
                continue;
            }

            $jumlahBulan = $mulai->diffInMonths($sampai) + 1;
            $now = now();
            $rows = [];
            $cursor = $mulai->copy();

            while ($cursor->lte($sampai)) {
                $rows[] = [
                    'user_id' => $user->id,
                    'bulan' => $cursor->month,
                    'tahun' => $cursor->year,
                    'nominal' => $nominal,
                    'status' => 'belum_lunas',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $cursor->addMonth();
            }

            $created = KasBulanan::query()->insertOrIgnore($rows);
            $skipped = $jumlahBulan - $created;

            $totalCreated += $created;
            $totalSkipped += $skipped;

            $labelMulai = $mulai->translatedFormat('M Y');
            $labelSampai = $sampai->translatedFormat('M Y');

            $this->line("- {$user->name}: {$labelMulai} s/d {$labelSampai} | dibuat {$created}" . ($skipped > 0 ? " | dilewati {$skipped}" : ''));
        }

        $this->newLine();
        $this->info("Selesai. Total dibuat: {$totalCreated} | Dilewati: {$totalSkipped} | Tanpa generate: {$totalTidakPerluGenerate}");

        return self::SUCCESS;
    }

    private function resetKasData(): bool
    {
        $kasCount = KasBulanan::count();
        $pembayaranCount = KasPembayaran::count();
        $danaMasukCount = DanaMasuk::query()
            ->where('sumber_type', KasPembayaran::class)
            ->count();

        $this->warn('Mode reset aktif. Data berikut akan dihapus:');
        $this->line("kas_bulanans: {$kasCount}");
        $this->line("kas_pembayarans: {$pembayaranCount}");
        $this->line("dana_masuks terkait kas: {$danaMasukCount}");

        if (
            ! $this->option('force')
            && ! $this->confirm('Lanjut reset data kas tersebut?')
        ) {
            $this->warn('Reset dibatalkan.');

            return false;
        }

        DB::transaction(function () {
            DanaMasuk::query()
                ->where('sumber_type', KasPembayaran::class)
                ->delete();

            KasPembayaran::query()->delete();
            KasBulanan::query()->delete();
        });

        $this->info('Data kas berhasil di-reset.');
        $this->newLine();

        return true;
    }

    private function parseMonthOption(string $option): ?Carbon
    {
        $value = $this->option($option);

        if (! $value) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m', $value)->startOfMonth();
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException("Format --{$option} harus YYYY-MM.");
        }
    }

    private function resolveStartMonth(User $user, ?Carbon $batasDari): Carbon
    {
        $anggotaDibuat = $user->anggota?->created_at ?? $user->created_at ?? now();
        $mulaiDariAnggota = $anggotaDibuat->copy()->startOfMonth();

        return $batasDari && $mulaiDariAnggota->lt($batasDari)
            ? $batasDari->copy()
            : $mulaiDariAnggota;
    }
}

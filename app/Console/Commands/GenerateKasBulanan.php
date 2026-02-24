<?php

namespace App\Console\Commands;

use App\Models\KasBulanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateKasBulanan extends Command
{
    protected $signature = 'kas:generate-bulanan
                            {--dari=  : Dari bulan (format: YYYY-MM), default: bulan setelah data terakhir}
                            {--sampai= : Sampai bulan (format: YYYY-MM), default: bulan saat ini}
                            {--nominal=10000 : Nominal kas per bulan}';

    protected $description = 'Generate kas bulanan untuk semua anggota, dari data terakhir sampai bulan ini';

    public function handle(): int
    {
        $anggota = User::where('role', 'anggota')->get();

        if ($anggota->isEmpty()) {
            $this->warn('Tidak ada user dengan role anggota.');
            return Command::SUCCESS;
        }

        // Tentukan titik awal
        if ($this->option('dari')) {
            $mulai = Carbon::createFromFormat('Y-m', $this->option('dari'))->startOfMonth();
        } else {
            $latest = KasBulanan::orderByRaw('tahun DESC, bulan DESC')->first();

            if ($latest) {
                // Mulai dari bulan BERIKUTNYA setelah data terakhir
                $mulai = Carbon::create($latest->tahun, $latest->bulan, 1)->addMonth();
            } else {
                // Tidak ada data sama sekali, mulai dari bulan ini
                $mulai = now()->startOfMonth();
            }
        }

        // Tentukan titik akhir
        $sampai = $this->option('sampai')
            ? Carbon::createFromFormat('Y-m', $this->option('sampai'))->startOfMonth()
            : now()->startOfMonth();

        if ($mulai->gt($sampai)) {
            $this->info("Kas sudah up-to-date sampai {$sampai->format('F Y')}. Tidak ada yang perlu di-generate.");
            return Command::SUCCESS;
        }

        $nominal  = (int) $this->option('nominal');
        $bulanList = [];

        // Kumpulkan semua bulan yang perlu di-generate
        $cursor = $mulai->copy();
        while ($cursor->lte($sampai)) {
            $bulanList[] = $cursor->copy();
            $cursor->addMonth();
        }

        $nominal_label = 'Rp ' . number_format($nominal, 0, ',', '.');
        $this->info("Generate kas untuk {$anggota->count()} anggota, {$mulai->format('M Y')} → {$sampai->format('M Y')}");
        $this->info("Nominal per bulan: {$nominal_label}");
        $this->newLine();

        $totalCreated = 0;
        $totalSkipped = 0;

        foreach ($bulanList as $bulan) {
            $created = 0;
            $skipped = 0;

            foreach ($anggota as $user) {
                $exists = KasBulanan::where('user_id', $user->id)
                    ->where('bulan', $bulan->month)
                    ->where('tahun', $bulan->year)
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                KasBulanan::create([
                    'user_id' => $user->id,
                    'bulan'   => $bulan->month,
                    'tahun'   => $bulan->year,
                    'nominal' => $nominal,
                    'status'  => 'belum_lunas',
                ]);

                $created++;
            }

            $totalCreated += $created;
            $totalSkipped += $skipped;

            $label = $bulan->translatedFormat('F Y');
            if ($created > 0) {
                $this->line("  <fg=green>✔</> {$label}: {$created} dibuat" . ($skipped > 0 ? ", {$skipped} dilewati" : ''));
            } else {
                $this->line("  <fg=yellow>⏭</> {$label}: semua sudah ada ({$skipped} dilewati)");
            }
        }

        $this->newLine();
        $this->info("Selesai! Total dibuat: {$totalCreated} | Dilewati: {$totalSkipped}");

        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\KasBulanan;
use Carbon\Carbon;

class GenerateKasBulanan extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'kas:generate-bulanan
                            {--bulan= : Bulan (1-12)}
                            {--tahun= : Tahun (contoh: 2025)}';

    /**
     * The console command description.
     */
    protected $description = 'Generate data kas bulanan untuk semua anggota';

    public function handle(): int
    {
        $bulan = $this->option('bulan') ?? now()->month;
        $tahun = $this->option('tahun') ?? now()->year;

        $this->info("Generate kas bulan {$bulan}-{$tahun}");

        $anggota = User::where('role', 'anggota')->get();

        if ($anggota->isEmpty()) {
            $this->warn('Tidak ada user dengan role anggota.');
            return Command::SUCCESS;
        }

        $created = 0;
        $skipped = 0;

        foreach ($anggota as $user) {

            // Cegah duplikasi kas bulan yang sama
            $exists = KasBulanan::where('user_id', $user->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            KasBulanan::create([
                'user_id' => $user->id,
                'bulan'   => $bulan,
                'tahun'   => $tahun,
                'nominal' => 10000, // kas per bulan
                'status'  => 'belum_lunas',
            ]);

            $created++;
        }

        $this->info("✔ Kas dibuat: {$created}");
        $this->info("⏭ Dilewati (sudah ada): {$skipped}");

        return Command::SUCCESS;
    }
}

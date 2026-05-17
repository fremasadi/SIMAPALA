<?php

namespace App\Console\Commands;

use App\Models\Alat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MoveAlatImagesToPublic extends Command
{
    protected $signature = 'simapala:move-alat-images-to-public
        {--force : Salin file dari storage private ke public}
        {--delete-source : Hapus file private setelah berhasil disalin ke public}';

    protected $description = 'Salin foto alat lama dari disk private ke disk public agar bisa diakses dari halaman publik.';

    public function handle(): int
    {
        $privateDisk = Storage::disk('local');
        $publicDisk = Storage::disk('public');

        $alats = Alat::query()
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderBy('id')
            ->get(['id', 'kode_alat', 'nama_alat', 'image']);

        if ($alats->isEmpty()) {
            $this->info('Tidak ada foto alat yang perlu diperiksa.');

            return self::SUCCESS;
        }

        $copied = 0;
        $alreadyPublic = 0;
        $missing = 0;

        $this->line('Mode: ' . ($this->option('force') ? 'eksekusi' : 'dry-run'));
        $this->newLine();

        foreach ($alats as $alat) {
            $path = $alat->image;

            if ($publicDisk->exists($path)) {
                $alreadyPublic++;
                $this->line("SKIP public sudah ada: {$path}");
                continue;
            }

            if (! $privateDisk->exists($path)) {
                $missing++;
                $this->warn("MISSING: {$path} ({$alat->kode_alat} - {$alat->nama_alat})");
                continue;
            }

            if (! $this->option('force')) {
                $copied++;
                $this->line("AKAN DISALIN: {$path}");
                continue;
            }

            $publicDisk->put($path, $privateDisk->get($path));
            $copied++;
            $this->info("DISALIN: {$path}");

            if ($this->option('delete-source')) {
                $privateDisk->delete($path);
                $this->line("  sumber private dihapus");
            }
        }

        $this->newLine();
        $this->info('Ringkasan:');
        $this->line("Siap/disalin: {$copied}");
        $this->line("Sudah public: {$alreadyPublic}");
        $this->line("Tidak ditemukan: {$missing}");

        if (! $this->option('force')) {
            $this->newLine();
            $this->comment('Dry-run selesai. Jalankan ulang dengan --force untuk benar-benar menyalin file.');
        }

        return self::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\TransaksiAlat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FreshTransaksiAlatData extends Command
{
    protected $signature = 'simapala:fresh-transaksi-alat
        {--force : Jalankan tanpa konfirmasi}
        {--with-dana-masuk : Hapus juga dana_masuks yang bersumber dari transaksi alat}';

    protected $description = 'Kosongkan data transaksi alat dan pembayaran, lalu set semua alat menjadi tersedia.';

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('Data transaksi alat dan pembayaran akan dihapus. Lanjutkan?')) {
            $this->warn('Dibatalkan.');

            return self::SUCCESS;
        }

        $tables = [
            'alat_hilang_logs',
            'detail_transaksis',
            'pembayarans',
            'transaksi_alats',
        ];

        $counts = [];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $counts[$table] = DB::table($table)->count();
            }
        }

        $danaMasukCount = 0;
        if ($this->option('with-dana-masuk') && Schema::hasTable('dana_masuks')) {
            $danaMasukCount = DB::table('dana_masuks')
                ->where('sumber_type', TransaksiAlat::class)
                ->count();
        }

        Schema::disableForeignKeyConstraints();

        try {
            if ($this->option('with-dana-masuk') && Schema::hasTable('dana_masuks')) {
                DB::table('dana_masuks')
                    ->where('sumber_type', TransaksiAlat::class)
                    ->delete();
            }

            foreach ($tables as $table) {
                if (Schema::hasTable($table)) {
                    DB::table($table)->delete();
                }
            }

            $updatedAlats = Schema::hasTable('alats')
                ? DB::table('alats')->update(['status' => 'tersedia'])
                : 0;
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        foreach ($counts as $table => $count) {
            $this->line("{$table}: {$count} data dihapus");
        }

        if ($this->option('with-dana-masuk')) {
            $this->line("dana_masuks transaksi alat: {$danaMasukCount} data dihapus");
        }

        $this->info("Status alat berhasil diset ke tersedia untuk {$updatedAlats} data.");

        return self::SUCCESS;
    }
}

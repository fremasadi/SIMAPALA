<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE dana_masuks MODIFY COLUMN jenis ENUM(
            'penyewaan',
            'denda_telat',
            'denda_rusak',
            'denda_hilang',
            'kas',
            'sumbangan',
            'dana_kampus'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::table('dana_masuks')
            ->where('jenis', 'denda_hilang')
            ->update(['jenis' => 'denda_rusak']);

        DB::statement("ALTER TABLE dana_masuks MODIFY COLUMN jenis ENUM(
            'penyewaan',
            'denda_telat',
            'denda_rusak',
            'kas',
            'sumbangan',
            'dana_kampus'
        ) NOT NULL");
    }
};

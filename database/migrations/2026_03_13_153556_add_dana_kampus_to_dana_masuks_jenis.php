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
            'kas',
            'sumbangan',
            'dana_kampus'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE dana_masuks MODIFY COLUMN jenis ENUM(
            'penyewaan',
            'denda_telat',
            'denda_rusak',
            'kas',
            'sumbangan'
        ) NOT NULL");
    }
};

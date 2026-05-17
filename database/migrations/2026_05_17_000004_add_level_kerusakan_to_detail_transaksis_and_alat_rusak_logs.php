<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->enum('level_kerusakan', ['rusak_sedang', 'rusak_berat'])
                ->nullable()
                ->after('kondisi_kembali');
        });

        Schema::table('alat_rusak_logs', function (Blueprint $table) {
            $table->enum('level_kerusakan', ['rusak_sedang', 'rusak_berat'])
                ->nullable()
                ->after('detail_transaksi_id');
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->dropColumn('level_kerusakan');
        });

        Schema::table('alat_rusak_logs', function (Blueprint $table) {
            $table->dropColumn('level_kerusakan');
        });
    }
};

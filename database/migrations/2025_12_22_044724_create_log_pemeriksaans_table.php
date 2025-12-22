<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_pemeriksaans', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('detail_transaksi_id')
                  ->constrained('detail_transaksis')
                  ->onDelete('cascade')
                  ->comment('Referensi ke detail transaksi');

            $table->foreignId('alat_id')
                  ->constrained('alats')
                  ->onDelete('cascade')
                  ->comment('Referensi ke alat yang diperiksa');

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('User yang melakukan pemeriksaan');

            // Status Kondisi
            $table->enum('kondisi_sebelum', [
                'baik',
                'rusak_ringan',
                'rusak_berat',
                'hilang'
            ])->comment('Kondisi alat sebelum pemeriksaan');

            $table->enum('kondisi_sesudah', [
                'baik',
                'rusak_ringan',
                'rusak_berat',
                'hilang'
            ])->comment('Kondisi alat setelah pemeriksaan');

            // Catatan & Tindakan
            $table->text('catatan')
                  ->nullable()
                  ->comment('Catatan detail hasil pemeriksaan');

            $table->enum('tindakan', [
                'tidak_ada',
                'maintenance',
                'perbaikan',
                'penggantian',
                'penghapusan'
            ])->default('tidak_ada')
              ->comment('Tindakan yang diambil setelah pemeriksaan');

            // Tanggal Pemeriksaan
            $table->datetime('tanggal_pemeriksaan')
                  ->default(DB::raw('CURRENT_TIMESTAMP'))
                  ->comment('Waktu pemeriksaan dilakukan');

            $table->timestamps();

            // Indexes untuk performa query
            $table->index('detail_transaksi_id');
            $table->index('alat_id');
            $table->index('user_id');
            $table->index('tanggal_pemeriksaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_pemeriksaans');
    }
};

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
        Schema::create('kas_pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kas_bulanan_id')
                ->constrained('kas_bulanans')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->double('nominal');
            $table->enum('metode', ['dana', 'cash'])
                ->default('dana');

            $table->string('bukti_bayar')->nullable();

            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])
                ->default('menunggu');

            $table->date('tanggal_bayar');
            $table->text('keterangan')->nullable();

            // Admin / bendahara yang verifikasi
            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_pembayarans');
    }
};

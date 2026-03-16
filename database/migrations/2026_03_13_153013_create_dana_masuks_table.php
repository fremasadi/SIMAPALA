<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dana_masuks', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', [
                'penyewaan',
                'denda_telat',
                'denda_rusak',
                'kas',
                'sumbangan',
            ]);
            $table->decimal('nominal', 12, 2);
            $table->string('keterangan')->nullable();
            $table->date('tanggal');

            // Opsional: siapa yang membayar/menyumbang
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Referensi ke sumber (transaksi/kas/dll) — polymorphic
            $table->nullableMorphs('sumber');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dana_masuks');
    }
};

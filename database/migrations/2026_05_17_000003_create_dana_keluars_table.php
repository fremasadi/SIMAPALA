<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dana_keluars', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', [
                'pembelian_inventaris',
                'operasional',
                'kegiatan',
                'perawatan',
                'lainnya',
            ]);
            $table->decimal('nominal', 12, 2);
            $table->string('keterangan')->nullable();
            $table->date('tanggal');
            $table->string('bukti_pengeluaran')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->nullableMorphs('sumber');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dana_keluars');
    }
};

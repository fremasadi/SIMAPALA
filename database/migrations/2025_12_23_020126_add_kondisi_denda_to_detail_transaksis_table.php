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
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->enum('kondisi_kembali', ['baik', 'rusak', 'hilang'])
                  ->default('baik')
                  ->after('alat_id');

            $table->double('denda')
                  ->default(0)
                  ->after('kondisi_kembali');

            $table->text('keterangan')
                  ->nullable()
                  ->after('denda');
            $table->string('foto_kembali')
                  ->nullable()
                  ->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            //
        });
    }
};

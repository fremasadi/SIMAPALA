<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->decimal('denda_telat', 10, 2)->nullable()->default(0)->after('kondisi_kembali');
            $table->decimal('denda_rusak', 10, 2)->nullable()->default(0)->after('denda_telat');
            $table->dropColumn('denda');
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->decimal('denda', 10, 2)->nullable()->default(0)->after('kondisi_kembali');
            $table->dropColumn(['denda_telat', 'denda_rusak']);
        });
    }
};

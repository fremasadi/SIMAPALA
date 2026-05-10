<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alat_rusak_logs', function (Blueprint $table) {
            $table->string('foto_pembayaran')->nullable()->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('alat_rusak_logs', function (Blueprint $table) {
            $table->dropColumn('foto_pembayaran');
        });
    }
};

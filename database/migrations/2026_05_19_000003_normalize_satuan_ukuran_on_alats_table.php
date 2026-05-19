<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('alats')
            ->whereIn('satuan', ['unit', 'set', 'pasang', 'pcs', 'buah'])
            ->update(['satuan' => 'centimeter']);
    }

    public function down(): void
    {
        //
    }
};

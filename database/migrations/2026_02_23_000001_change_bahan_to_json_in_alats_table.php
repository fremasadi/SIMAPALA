<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing string values to JSON array format before changing column type
        $rows = DB::table('alats')->whereNotNull('bahan')->get(['id', 'bahan']);

        foreach ($rows as $row) {
            $value = $row->bahan;

            // Skip if already valid JSON array
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                continue;
            }

            // Convert plain string to JSON array
            DB::table('alats')
                ->where('id', $row->id)
                ->update(['bahan' => json_encode(array_values(array_filter(array_map('trim', explode(',', $value)))))]);
        }

        Schema::table('alats', function (Blueprint $table) {
            $table->json('bahan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            $table->string('bahan')->nullable()->change();
        });
    }
};

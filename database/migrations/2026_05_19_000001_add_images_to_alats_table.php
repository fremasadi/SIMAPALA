<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
        });

        DB::table('alats')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->whereNull('images')
            ->orderBy('id')
            ->get(['id', 'image'])
            ->each(function ($alat) {
                DB::table('alats')
                    ->where('id', $alat->id)
                    ->update(['images' => json_encode([$alat->image])]);
            });
    }

    public function down(): void
    {
        DB::table('alats')
            ->whereNull('image')
            ->whereNotNull('images')
            ->orderBy('id')
            ->get(['id', 'images'])
            ->each(function ($alat) {
                $images = json_decode($alat->images, true);
                $firstImage = is_array($images) ? ($images[0] ?? null) : null;

                if ($firstImage) {
                    DB::table('alats')
                        ->where('id', $alat->id)
                        ->update(['image' => $firstImage]);
                }
            });

        Schema::table('alats', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};

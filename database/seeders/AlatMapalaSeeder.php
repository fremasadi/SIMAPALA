<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AlatMapalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alat = [
            [
                'kode_alat' => 'AL001',
                'nama_alat' => 'Tenda Dome 4 Orang',
                'status' => 'tersedia',
                'harga_sewa' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alat' => 'AL002',
                'nama_alat' => 'Carrier 60L',
                'status' => 'tersedia',
                'harga_sewa' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alat' => 'AL003',
                'nama_alat' => 'Matras',
                'status' => 'tersedia',
                'harga_sewa' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alat' => 'AL004',
                'nama_alat' => 'Kompor Portable',
                'status' => 'tersedia',
                'harga_sewa' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_alat' => 'AL005',
                'nama_alat' => 'Headlamp',
                'status' => 'tersedia',
                'harga_sewa' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('alats')->insert($alat);
    }
}

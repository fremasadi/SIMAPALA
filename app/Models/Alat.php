<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alats';

    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'status',
        'harga_sewa',
    ];

    protected $casts = [
        'harga_sewa' => 'float',
    ];
}

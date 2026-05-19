<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alats';

    protected $fillable = ['kode_alat', 'nama_alat', 'satuan', 'ukuran', 'bahan', 'status', 'harga_alat', 'harga_sewa', 'image', 'images'];

    protected $casts = [
        'harga_alat' => 'float',
        'harga_sewa' => 'float',
        'bahan'      => 'array',
        'images'     => 'array',
    ];

    public function getImageAttribute($value): ?string
    {
        if (is_array($this->images) && ! empty($this->images[0])) {
            return $this->images[0];
        }

        return $value;
    }
}

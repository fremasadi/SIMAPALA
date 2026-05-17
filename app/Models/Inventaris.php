<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Inventaris extends Model
{
    protected $table = 'inventarises';

    protected $fillable = [
        'kode_inventaris',
        'nama_barang',
        'kategori',
        'jumlah',
        'kondisi',
        'tanggal_perolehan',
        'harga_perolehan',
        'sumber_dana',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_perolehan' => 'date',
        'harga_perolehan' => 'decimal:2',
    ];

    public function danaKeluar(): MorphOne
    {
        return $this->morphOne(DanaKeluar::class, 'sumber');
    }

    protected static function booted(): void
    {
        static::deleting(function (Inventaris $inventaris) {
            $inventaris->danaKeluar()->delete();
        });
    }
}

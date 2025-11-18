<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TransaksiAlat;
use App\Models\Alat;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksis';

    protected $fillable = [
        'transaksi_id',
        'alat_id',
        'kondisi_kembali',
    ];

    // Relasi ke transaksi
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiAlat::class, 'transaksi_id');
    }

    // Relasi ke alat
    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}

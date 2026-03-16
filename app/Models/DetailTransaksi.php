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
        'denda_telat',
        'denda_rusak',
        'keterangan',
        'foto_kembali',
    ];

    protected $casts = [
        'denda_telat' => 'decimal:2',
        'denda_rusak' => 'decimal:2',
    ];

    public function getTotalDendaAttribute(): float
    {
        return (float) $this->denda_telat + (float) $this->denda_rusak;
    }

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

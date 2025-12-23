<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasPembayaran extends Model
{
    protected $table = 'kas_pembayarans';

    protected $fillable = [
        'kas_bulanan_id',
        'user_id',
        'nominal',
        'metode',
        'bukti_bayar',
        'status',
        'tanggal_bayar',
        'keterangan',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'nominal' => 'float',
        'tanggal_bayar' => 'date',
        'verified_at' => 'datetime',
    ];

    /**
     * Relasi ke kas bulanan
     */
    public function kasBulanan(): BelongsTo
    {
        return $this->belongsTo(KasBulanan::class, 'kas_bulanan_id');
    }

    /**
     * Relasi ke user pembayar
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke admin / bendahara yang verifikasi
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}

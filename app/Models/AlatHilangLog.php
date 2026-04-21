<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlatHilangLog extends Model
{
    protected $table = 'alat_hilang_logs';

    protected $fillable = [
        'alat_id',
        'user_id',
        'transaksi_id',
        'denda',
        'keterangan',
        'foto_pembayaran',
    ];

    protected $casts = [
        'denda' => 'decimal:2',
    ];

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiAlat::class, 'transaksi_id');
    }
}

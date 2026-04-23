<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlatRusakLog extends Model
{
    protected $table = 'alat_rusak_logs';

    protected $fillable = [
        'alat_id',
        'user_id',
        'transaksi_id',
        'detail_transaksi_id',
        'denda',
        'keterangan',
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

    public function detailTransaksi(): BelongsTo
    {
        return $this->belongsTo(DetailTransaksi::class, 'detail_transaksi_id');
    }
}

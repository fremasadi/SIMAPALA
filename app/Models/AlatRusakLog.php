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
        'level_kerusakan',
        'denda',
        'keterangan',
        'foto_pembayaran',
    ];

    protected $casts = [
        'denda' => 'decimal:2',
    ];

    const LEVEL_KERUSAKAN = [
        'rusak_sedang' => 'Rusak Sedang',
        'rusak_berat' => 'Rusak Berat',
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

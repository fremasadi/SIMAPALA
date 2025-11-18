<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransaksiAlat extends Model
{
    protected $table = 'transaksi_alats';

    protected $fillable = [
        'user_id',
        'jenis_transaksi',
        'tanggal_ajuan',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'total_biaya',
    ];

    protected $casts = [
        'total_biaya' => 'decimal:2',
        'tanggal_ajuan' => 'date',
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    // Relasi ke pembayaran
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'transaksi_id');
    }

    // Generate unique order ID
    public function generateOrderId(): string
    {
        return 'ORDER-' . $this->id . '-' . time();
    }
}
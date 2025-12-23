<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasBulanan extends Model
{
    protected $table = 'kas_bulanans';

    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'nominal',
        'status',
    ];

    protected $casts = [
        'nominal' => 'float',
    ];

    /**
     * Relasi ke user (anggota)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke pembayaran kas (cicilan)
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(KasPembayaran::class, 'kas_bulanan_id');
    }

    /**
     * Total pembayaran yang sudah diterima
     */
    public function totalDibayar(): float
    {
        return $this->pembayarans()
            ->where('status', 'diterima')
            ->sum('nominal');
    }

    /**
     * Cek apakah kas sudah lunas
     */
    public function isLunas(): bool
    {
        return $this->totalDibayar() >= $this->nominal;
    }

    public function updateStatus(): void
{
    $totalDiterima = $this->pembayarans()
        ->where('status', 'diterima')
        ->sum('nominal');

    $this->status = $totalDiterima >= $this->nominal
        ? 'lunas'
        : 'belum_lunas';

    $this->save();
}

}

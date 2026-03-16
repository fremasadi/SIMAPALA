<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DanaMasuk extends Model
{
    protected $table = 'dana_masuks';

    protected $fillable = [
        'jenis',
        'nominal',
        'keterangan',
        'tanggal',
        'status',
        'user_id',
        'sumber_type',
        'sumber_id',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal' => 'date',
    ];

    // Jenis yang langsung approved karena diinput oleh admin
    const AUTO_APPROVED = ['denda_telat', 'denda_rusak', 'penyewaan'];

    const JENIS = [
        'penyewaan'   => 'Penyewaan Alat',
        'denda_telat' => 'Denda Telat',
        'denda_rusak' => 'Denda Rusak',
        'kas'         => 'Kas',
        'sumbangan'   => 'Sumbangan',
        'dana_kampus' => 'Dana Kampus',
    ];

    public function getJenisLabelAttribute(): string
    {
        return self::JENIS[$this->jenis] ?? ucfirst($this->jenis);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi polymorphic ke sumber (TransaksiAlat, KasPembayaran, dll)
    public function sumber(): MorphTo
    {
        return $this->morphTo();
    }
}

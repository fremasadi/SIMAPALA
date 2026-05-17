<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DanaKeluar extends Model
{
    protected $table = 'dana_keluars';

    protected $fillable = [
        'jenis',
        'nominal',
        'keterangan',
        'tanggal',
        'bukti_pengeluaran',
        'user_id',
        'sumber_type',
        'sumber_id',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal' => 'date',
    ];

    const JENIS = [
        'pembelian_inventaris' => 'Pembelian Inventaris',
        'operasional' => 'Operasional',
        'kegiatan' => 'Kegiatan',
        'perawatan' => 'Perawatan',
        'lainnya' => 'Lainnya',
    ];

    public function getJenisLabelAttribute(): string
    {
        return self::JENIS[$this->jenis] ?? ucfirst($this->jenis);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sumber(): MorphTo
    {
        return $this->morphTo();
    }
}

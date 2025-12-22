<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPemeriksaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'log_pemeriksaans';

    /**
     * Kolom yang bisa diisi mass assignment
     */
    protected $fillable = [
        'detail_transaksi_id',
        'alat_id',
        'user_id',
        'kondisi_sebelum',
        'kondisi_sesudah',
        'catatan',
        'tindakan',
        'tanggal_pemeriksaan',
    ];

    /**
     * Kolom yang harus di-cast ke tipe data tertentu
     */
    protected $casts = [
        'tanggal_pemeriksaan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Konstanta untuk kondisi alat
     */
    const KONDISI_BAIK = 'baik';
    const KONDISI_RUSAK_RINGAN = 'rusak_ringan';
    const KONDISI_RUSAK_BERAT = 'rusak_berat';
    const KONDISI_HILANG = 'hilang';

    /**
     * Konstanta untuk tindakan
     */
    const TINDAKAN_TIDAK_ADA = 'tidak_ada';
    const TINDAKAN_MAINTENANCE = 'maintenance';
    const TINDAKAN_PERBAIKAN = 'perbaikan';
    const TINDAKAN_PENGGANTIAN = 'penggantian';
    const TINDAKAN_PENGHAPUSAN = 'penghapusan';

    /**
     * Relasi ke DetailTransaksi
     */
    public function detailTransaksi()
    {
        return $this->belongsTo(DetailTransaksi::class, 'detail_transaksi_id');
    }

    /**
     * Relasi ke Alat
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    /**
     * Relasi ke User (Pemeriksa)
     */
    public function pemeriksa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Transaksi melalui DetailTransaksi
     */
    public function transaksi()
    {
        return $this->hasOneThrough(
            TransaksiAlat::class,
            DetailTransaksi::class,
            'id', // Foreign key di detail_transaksis
            'id', // Foreign key di transaksi_alats
            'detail_transaksi_id', // Local key di log_pemeriksaans
            'transaksi_id' // Local key di detail_transaksis
        );
    }

    /**
     * Scope untuk filter berdasarkan kondisi
     */
    public function scopeKondisiMemburuk($query)
    {
        return $query->whereRaw("
            CASE kondisi_sebelum
                WHEN 'baik' THEN 0
                WHEN 'rusak_ringan' THEN 1
                WHEN 'rusak_berat' THEN 2
                WHEN 'hilang' THEN 3
            END <
            CASE kondisi_sesudah
                WHEN 'baik' THEN 0
                WHEN 'rusak_ringan' THEN 1
                WHEN 'rusak_berat' THEN 2
                WHEN 'hilang' THEN 3
            END
        ");
    }

    /**
     * Scope untuk filter berdasarkan alat
     */
    public function scopeByAlat($query, $alat_id)
    {
        return $query->where('alat_id', $alat_id);
    }

    /**
     * Scope untuk filter berdasarkan pemeriksa
     */
    public function scopeByPemeriksa($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByTanggal($query, $start, $end)
    {
        return $query->whereBetween('tanggal_pemeriksaan', [$start, $end]);
    }

    /**
     * Scope untuk log yang memerlukan tindakan
     */
    public function scopePerluTindakan($query)
    {
        return $query->whereIn('tindakan', [
            self::TINDAKAN_MAINTENANCE,
            self::TINDAKAN_PERBAIKAN,
            self::TINDAKAN_PENGGANTIAN,
            self::TINDAKAN_PENGHAPUSAN
        ]);
    }

    /**
     * Accessor untuk label kondisi sebelum
     */
    public function getKondisiSebelumLabelAttribute()
    {
        return match($this->kondisi_sebelum) {
            'baik' => '✓ Baik',
            'rusak_ringan' => '⚠ Rusak Ringan',
            'rusak_berat' => '✗ Rusak Berat',
            'hilang' => '⊗ Hilang',
            default => '-'
        };
    }

    /**
     * Accessor untuk label kondisi sesudah
     */
    public function getKondisiSesudahLabelAttribute()
    {
        return match($this->kondisi_sesudah) {
            'baik' => '✓ Baik',
            'rusak_ringan' => '⚠ Rusak Ringan',
            'rusak_berat' => '✗ Rusak Berat',
            'hilang' => '⊗ Hilang',
            default => '-'
        };
    }

    /**
     * Accessor untuk label tindakan
     */
    public function getTindakanLabelAttribute()
    {
        return match($this->tindakan) {
            'tidak_ada' => '-',
            'maintenance' => '🔧 Maintenance',
            'perbaikan' => '🛠 Perbaikan',
            'penggantian' => '♻ Penggantian',
            'penghapusan' => '🗑 Penghapusan',
            default => '-'
        };
    }

    /**
     * Cek apakah kondisi memburuk
     */
    public function isKondisiMemburuk()
    {
        $bobot = [
            'baik' => 0,
            'rusak_ringan' => 1,
            'rusak_berat' => 2,
            'hilang' => 3
        ];

        return ($bobot[$this->kondisi_sesudah] ?? 0) > ($bobot[$this->kondisi_sebelum] ?? 0);
    }

    /**
     * Cek apakah kondisi membaik
     */
    public function isKondisiMembaik()
    {
        $bobot = [
            'baik' => 0,
            'rusak_ringan' => 1,
            'rusak_berat' => 2,
            'hilang' => 3
        ];

        return ($bobot[$this->kondisi_sesudah] ?? 0) < ($bobot[$this->kondisi_sebelum] ?? 0);
    }

    /**
     * Static method untuk membuat log pemeriksaan
     */
    public static function createLog($data)
    {
        return self::create([
            'detail_transaksi_id' => $data['detail_transaksi_id'],
            'alat_id' => $data['alat_id'],
            'user_id' => auth()->id(),
            'kondisi_sebelum' => $data['kondisi_sebelum'],
            'kondisi_sesudah' => $data['kondisi_sesudah'],
            'catatan' => $data['catatan'] ?? null,
            'tindakan' => $data['tindakan'] ?? self::TINDAKAN_TIDAK_ADA,
            'tanggal_pemeriksaan' => now(),
        ]);
    }
}
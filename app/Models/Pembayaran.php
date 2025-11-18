<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'transaksi_id',
        'order_id',
        'transaction_id',
        'gross_amount',
        'payment_type',
        'bank',
        'va_number',
        'transaction_status',
        'fraud_status',
        'transaction_time',
        'settlement_time',
        'payment_url',
        'midtrans_response',
        'notes',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'midtrans_response' => 'array',
        'transaction_time' => 'datetime',
        'settlement_time' => 'datetime',
    ];

    // Relasi ke transaksi
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiAlat::class, 'transaksi_id');
    }

    // Check if payment is successful
    public function isSuccessful(): bool
    {
        return in_array($this->transaction_status, ['settlement', 'capture']);
    }

    // Check if payment is pending
    public function isPending(): bool
    {
        return $this->transaction_status === 'pending';
    }

    // Check if payment is failed
    public function isFailed(): bool
    {
        return in_array($this->transaction_status, ['deny', 'cancel', 'expire', 'failure']);
    }
}
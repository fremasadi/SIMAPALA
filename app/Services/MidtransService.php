<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\TransaksiAlat;
use App\Models\Pembayaran;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap Token untuk pembayaran
     */
    public function createTransaction(TransaksiAlat $transaksi)
    {
        $orderId = $transaksi->generateOrderId();
        
        // Item details
        $itemDetails = [];
        foreach ($transaksi->detailTransaksis as $detail) {
            $durasi = $transaksi->tanggal_pinjam->diffInDays($transaksi->tanggal_kembali);
            $itemDetails[] = [
                'id' => $detail->alat->id,
                'price' => (int) $detail->alat->harga_sewa,
                'quantity' => $durasi > 0 ? $durasi : 1,
                'name' => $detail->alat->nama_alat . ' (' . $durasi . ' hari)',
            ];
        }

        // Customer details
        $customerDetails = [
            'first_name' => $transaksi->user->name,
            'email' => $transaksi->user->email,
            'phone' => $transaksi->user->phone ?? '',
        ];

        // Transaction details
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => (int) $transaksi->total_biaya,
        ];

        // Snap parameters
        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => [
                'credit_card',
                'bca_va',
                'bni_va',
                'bri_va',
                'permata_va',
                'other_va',
                'gopay',
                'qris',
                'shopeepay',
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan data pembayaran
            $pembayaran = Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'order_id' => $orderId,
                'gross_amount' => $transaksi->total_biaya,
                'transaction_status' => 'pending',
                'payment_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken,
            ]);

            return [
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'pembayaran' => $pembayaran,
            ];
        } catch (\Exception $e) {
            throw new \Exception('Error creating payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle notification dari Midtrans
     */
    public function handleNotification($notification)
    {
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;
        $orderId = $notification->order_id;

        $pembayaran = Pembayaran::where('order_id', $orderId)->firstOrFail();

        // Update pembayaran data
        $updateData = [
            'transaction_id' => $notification->transaction_id,
            'payment_type' => $notification->payment_type ?? null,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'transaction_time' => $notification->transaction_time ?? now(),
            'midtrans_response' => json_decode(json_encode($notification), true),
        ];

        // Handle VA number untuk bank transfer
        if ($notification->payment_type === 'bank_transfer') {
            $updateData['bank'] = $notification->va_numbers[0]->bank ?? null;
            $updateData['va_number'] = $notification->va_numbers[0]->va_number ?? null;
        }

        // Update status berdasarkan transaction_status
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $updateData['transaction_status'] = 'capture';
                $this->updateTransaksiStatus($pembayaran->transaksi, 'disetujui');
            }
        } elseif ($transactionStatus == 'settlement') {
            $updateData['transaction_status'] = 'settlement';
            $updateData['settlement_time'] = now();
            $this->updateTransaksiStatus($pembayaran->transaksi, 'disetujui');
        } elseif ($transactionStatus == 'pending') {
            $updateData['transaction_status'] = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $updateData['transaction_status'] = $transactionStatus;
            $this->updateTransaksiStatus($pembayaran->transaksi, 'ditolak');
        }

        $pembayaran->update($updateData);

        return $pembayaran;
    }

    /**
     * Check transaction status
     */
    public function checkStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            return $status;
        } catch (\Exception $e) {
            throw new \Exception('Error checking status: ' . $e->getMessage());
        }
    }

    /**
     * Cancel transaction
     */
    public function cancelTransaction($orderId)
    {
        try {
            $cancel = Transaction::cancel($orderId);
            
            $pembayaran = Pembayaran::where('order_id', $orderId)->first();
            if ($pembayaran) {
                $pembayaran->update([
                    'transaction_status' => 'cancel',
                ]);
                $this->updateTransaksiStatus($pembayaran->transaksi, 'dibatalkan');
            }
            
            return $cancel;
        } catch (\Exception $e) {
            throw new \Exception('Error canceling transaction: ' . $e->getMessage());
        }
    }

    /**
     * Update status transaksi
     */
    private function updateTransaksiStatus(TransaksiAlat $transaksi, string $status)
    {
        $transaksi->update(['status' => $status]);
    }
}
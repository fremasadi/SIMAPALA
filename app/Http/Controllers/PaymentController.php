<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\TransaksiAlat;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Create Payment (Redirect dari Cart Checkout)
     */
    public function create(Request $request)
    {
        try {
            // Validasi input dari form checkout
            $validated = $request->validate([
                'tanggal_pinjam' => 'required|date',
                'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
                'total_biaya' => 'required|numeric|min:0',
            ]);

            // Ambil cart dari session
            $cart = session()->get('cart', []);
            
            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
            }

            DB::beginTransaction();

            // Buat transaksi baru
            $transaksi = TransaksiAlat::create([
                'user_id' => Auth::id(),
                'jenis_transaksi' => 'sewa',
                'tanggal_ajuan' => now(),
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'menunggu',
                'total_biaya' => $validated['total_biaya'],
            ]);

            // Simpan detail transaksi dari cart
            foreach ($cart as $item) {
                $transaksi->detailTransaksis()->create([
                    'alat_id' => $item['id'],
                    'kondisi_kembali' => null, // Belum dikembalikan
                ]);
            }

            // Check if already has pending/success payment
            $existingPayment = Pembayaran::where('transaksi_id', $transaksi->id)
                ->whereIn('transaction_status', ['pending', 'settlement', 'capture'])
                ->first();
                
            if ($existingPayment) {
                DB::commit();
                return redirect()->route('payment.show', $existingPayment->id);
            }

            // Generate Order ID
            $orderId = 'SEWA-' . $transaksi->id . '-' . time();

            // Customer Details
            $user = Auth::user();
            $customerDetails = [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '08123456789',
            ];

            // Item Details
            $itemDetails = [];
            foreach ($cart as $item) {
                $itemDetails[] = [
                    'id' => $item['id'],
                    'price' => (int) $item['harga_sewa'],
                    'quantity' => 1,
                    'name' => $item['nama_alat'] . ' - Sewa Alat',
                ];
            }

            // Create transaction
            $result = $this->midtrans->createTransaction(
                $orderId,
                (int) $validated['total_biaya'],
                $customerDetails,
                $itemDetails
            );

            if (!$result['success']) {
                DB::rollBack();
                return back()->with('error', 'Gagal membuat pembayaran: ' . $result['message']);
            }

            // Save to database
            $pembayaran = Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'order_id' => $orderId,
                'gross_amount' => $validated['total_biaya'],
                'transaction_status' => 'pending',
                'payment_url' => $result['payment_url'],
                'midtrans_response' => json_encode($result),
            ]);

            DB::commit();

            // Clear cart setelah berhasil
            session()->forget('cart');

            return redirect()->route('payment.show', $pembayaran->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show Payment Page
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['transaksi.detailTransaksis.alat', 'transaksi.user'])
            ->findOrFail($id);
        
        // Pastikan user hanya bisa melihat pembayaran miliknya sendiri
        if ($pembayaran->transaksi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Get latest status from Midtrans
        $statusResult = $this->midtrans->getTransactionStatus($pembayaran->order_id);
        
        if ($statusResult['success']) {
            $this->updatePaymentStatus($pembayaran, $statusResult['data']);
            $pembayaran->refresh();
        }

        return view('payment.show', compact('pembayaran'));
    }

    /**
     * Payment Callback from Midtrans
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $pembayaran = Pembayaran::where('order_id', $request->order_id)->first();
        
        if (!$pembayaran) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $this->updatePaymentStatus($pembayaran, $request->all());

        return response()->json(['message' => 'Callback processed']);
    }

    /**
     * Payment Finish (User redirected here after payment)
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $pembayaran = Pembayaran::where('order_id', $orderId)->first();

        if (!$pembayaran) {
            return redirect()->route('home')->with('error', 'Pembayaran tidak ditemukan');
        }

        // Get latest status
        $statusResult = $this->midtrans->getTransactionStatus($orderId);
        
        if ($statusResult['success']) {
            $this->updatePaymentStatus($pembayaran, $statusResult['data']);
            $pembayaran->refresh();
        }

        return redirect()->route('payment.show', $pembayaran->id)
            ->with('success', 'Terima kasih! Pembayaran Anda sedang diproses.');
    }

    /**
     * Check Payment Status (AJAX)
     */
    public function checkStatus($id)
    {
        try {
            $pembayaran = Pembayaran::with('transaksi')->findOrFail($id);
            
            // Pastikan user hanya bisa cek pembayaran miliknya sendiri
            if ($pembayaran->transaksi->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            // Get latest status from Midtrans
            $statusResult = $this->midtrans->getTransactionStatus($pembayaran->order_id);
            
            Log::info('Check Payment Status', [
                'order_id' => $pembayaran->order_id,
                'current_status' => $pembayaran->transaction_status,
                'midtrans_result' => $statusResult
            ]);
            
            if ($statusResult['success']) {
                $this->updatePaymentStatus($pembayaran, $statusResult['data']);
                
                // Refresh data setelah update
                $pembayaran->refresh();
                
                return response()->json([
                    'success' => true,
                    'status' => $pembayaran->transaction_status,
                    'message' => $pembayaran->getStatusLabel(),
                    'is_success' => $pembayaran->isSuccess(),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek status pembayaran: ' . ($statusResult['message'] ?? 'Unknown error'),
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Error checking payment status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update Payment Status
     */
    private function updatePaymentStatus($pembayaran, $data)
    {
        $transactionStatus = $data->transaction_status ?? $data['transaction_status'] ?? 'pending';
        $fraudStatus = $data->fraud_status ?? $data['fraud_status'] ?? null;
        $paymentType = $data->payment_type ?? $data['payment_type'] ?? null;

        $updateData = [
            'transaction_id' => $data->transaction_id ?? $data['transaction_id'] ?? null,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_type' => $paymentType,
            'midtrans_response' => is_array($data) ? $data : json_decode(json_encode($data), true),
        ];

        // Bank info for VA
        if (isset($data->va_numbers) || isset($data['va_numbers'])) {
            $vaNumbers = $data->va_numbers ?? $data['va_numbers'];
            if (!empty($vaNumbers)) {
                $vaNumber = is_array($vaNumbers) ? $vaNumbers[0] : $vaNumbers[0];
                $updateData['bank'] = $vaNumber->bank ?? $vaNumber['bank'] ?? null;
                $updateData['va_number'] = $vaNumber->va_number ?? $vaNumber['va_number'] ?? null;
            }
        }

        // Transaction time
        if (isset($data->transaction_time) || isset($data['transaction_time'])) {
            $updateData['transaction_time'] = $data->transaction_time ?? $data['transaction_time'];
        }

        // Settlement time & Update Transaksi Status
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $updateData['settlement_time'] = now();
            
            // Update transaksi status menjadi disetujui (siap diambil)
            $pembayaran->transaksi->update([
                'status' => 'disetujui',
            ]);

            Log::info('Payment settled, transaksi updated to disetujui', [
                'transaksi_id' => $pembayaran->transaksi_id,
                'order_id' => $pembayaran->order_id
            ]);
        }

        // Jika pembayaran gagal/expired/cancel
        if (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'])) {
            $pembayaran->transaksi->update([
                'status' => 'dibatalkan',
            ]);

            Log::info('Payment failed, transaksi cancelled', [
                'transaksi_id' => $pembayaran->transaksi_id,
                'order_id' => $pembayaran->order_id,
                'status' => $transactionStatus
            ]);
        }

        $pembayaran->update($updateData);
    }
}
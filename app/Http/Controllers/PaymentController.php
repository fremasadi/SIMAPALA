<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAlat;
use App\Models\Pembayaran;
use App\Services\MidtransService;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Create payment
     */
    public function createPayment(Request $request, $transaksiId)
    {
        try {
            $transaksi = TransaksiAlat::with(['detailTransaksis.alat', 'user'])
                ->findOrFail($transaksiId);

            // Check if user owns this transaction
            if ($transaksi->user_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized');
            }

            // Check if already has pending payment
            if ($transaksi->pembayaran && $transaksi->pembayaran->isPending()) {
                return redirect()->route('payment.show', $transaksi->pembayaran->id);
            }

            // Create payment
            $payment = $this->midtransService->createTransaction($transaksi);

            return view('payment.checkout', [
                'transaksi' => $transaksi,
                'snapToken' => $payment['snap_token'],
                'pembayaran' => $payment['pembayaran'],
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Show payment page
     */
    /**
 * Show payment page
 */
public function show($pembayaranId)
{
    $pembayaran = Pembayaran::with('transaksi')->findOrFail($pembayaranId);

    // Check if user owns this payment
    if ($pembayaran->transaksi->user_id !== auth()->id()) {
        abort(403);
    }

    // Load transaksi dengan relasi
    $transaksi = $pembayaran->transaksi->load('detailTransaksis.alat', 'user');

    // Get snap token if still pending
    if ($pembayaran->isPending() && !$pembayaran->payment_url) {
        $payment = $this->midtransService->createTransaction($pembayaran->transaksi);
        $snapToken = $payment['snap_token'];
    } else {
        $snapToken = null;
    }

    // UBAH INI: dari payment.show ke payment.checkout
    return view('payment.checkout', [
        'transaksi' => $transaksi,
        'snapToken' => $snapToken,
        'pembayaran' => $pembayaran
    ]);
}

/**
 * Get redirect URL for payment
 */
public function getRedirectUrl($pembayaranId)
{
    try {
        $pembayaran = Pembayaran::findOrFail($pembayaranId);
        
        // Check authorization
        if ($pembayaran->transaksi->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Get redirect URL from Midtrans
        $snapToken = $pembayaran->snap_token;
        
        // Midtrans redirect URL format
        $redirectUrl = "https://app.sandbox.midtrans.com/snap/v2/vtweb/" . $snapToken;
        
        // Untuk production gunakan:
        // $redirectUrl = "https://app.midtrans.com/snap/v2/vtweb/" . $snapToken;
        
        return response()->json([
            'redirect_url' => $redirectUrl,
            'snap_token' => $snapToken
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    /**
     * Handle Midtrans notification (webhook)
     */
    public function notification(Request $request)
    {
        try {
            $notification = $request->all();
            
            // Verify signature
            $this->midtransService->handleNotification((object) $notification);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Payment finish redirect
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $pembayaran = Pembayaran::where('order_id', $orderId)->firstOrFail();

        return redirect()->route('payment.result', $pembayaran->id);
    }

    /**
     * Show payment result
     */
    public function result($pembayaranId)
    {
        $pembayaran = Pembayaran::with('transaksi')->findOrFail($pembayaranId);

        // Check if user owns this payment
        if ($pembayaran->transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.result', compact('pembayaran'));
    }

    /**
     * Check payment status
     */
    public function checkStatus($pembayaranId)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($pembayaranId);
            
            $status = $this->midtransService->checkStatus($pembayaran->order_id);
            
            // Update local status
            $this->midtransService->handleNotification($status);

            return response()->json([
                'status' => 'success',
                'data' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel payment
     */
    public function cancel($pembayaranId)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($pembayaranId);

            // Check if user owns this payment
            if ($pembayaran->transaksi->user_id !== auth()->id()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
            }

            $this->midtransService->cancelTransaction($pembayaran->order_id);

            return redirect()->route('transaksi.index')
                ->with('success', 'Pembayaran berhasil dibatalkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membatalkan pembayaran: ' . $e->getMessage());
        }
    }
}
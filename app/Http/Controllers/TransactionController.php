<?php

namespace App\Http\Controllers;

use App\Models\TransaksiAlat;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display user's transaction history
     */
    public function index(Request $request)
    {
        $query = TransaksiAlat::with(['detailTransaksis.alat', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal_pinjam', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal_pinjam', '<=', $request->end_date);
        }

        $transactions = $query->paginate(10);

        // Statistics
        $stats = [
            'total' => TransaksiAlat::where('user_id', Auth::id())->count(),
            'aktif' => TransaksiAlat::where('user_id', Auth::id())->where('status', 'dipinjam')->count(),
            'selesai' => TransaksiAlat::where('user_id', Auth::id())->where('status', 'selesai')->count(),
            'dibatalkan' => TransaksiAlat::where('user_id', Auth::id())->where('status', 'dibatalkan')->count(),
        ];

        return view('transactions.index', compact('transactions', 'stats'));
    }

    /**
     * Display transaction detail
     */
    public function show($id)
    {
        $transaction = TransaksiAlat::with(['detailTransaksis.alat', 'pembayaran', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Cancel transaction (only for pending payment)
     */
    public function cancel($id)
    {
        $transaction = TransaksiAlat::where('user_id', Auth::id())->findOrFail($id);

        // Only allow cancel if status is menunggu_pembayaran
        if ($transaction->status !== 'menunggu_pembayaran') {
            return back()->with('error', 'Transaksi tidak dapat dibatalkan');
        }

        // Update transaction status
        $transaction->update([
            'status' => 'dibatalkan'
        ]);

        // Cancel payment if exists
        if ($transaction->pembayaran) {
            $transaction->pembayaran->update([
                'transaction_status' => 'cancel'
            ]);
        }

        return back()->with('success', 'Transaksi berhasil dibatalkan');
    }
}
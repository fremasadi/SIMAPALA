<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiAlat;
use App\Models\KasPembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        /**
         * 🔶 JUMLAH ALAT DIPINJAM
         */
        $dipinjam = TransaksiAlat::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        /**
         * 💰 SALDO KAS (hanya diterima)
         */
        $saldoKas = KasPembayaran::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->sum('nominal');

        /**
         * 🕒 AKTIVITAS TERBARU (peminjaman alat)
         */
        $aktivitas = TransaksiAlat::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->jenis_transaksi === 'pinjam'
                        ? 'Peminjaman Alat'
                        : 'Sewa Alat',
                    'status' => $item->status,
                    'waktu' => Carbon::parse($item->created_at)->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'stats' => [
                'dipinjam' => $dipinjam,
                'saldo_kas' => $saldoKas,
                'saldo_kas_formatted' => 'Rp ' . number_format($saldoKas, 0, ',', '.'),
            ],
            'aktivitas' => $aktivitas,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KasPembayaran;
use App\Models\TransaksiAlat;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
         * 🕒 AKTIVITAS TERBARU (peminjaman alat + pembayaran kas)
         */
        $aktivitasTransaksi = TransaksiAlat::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tipe' => 'transaksi_alat',
                    'judul' => $item->jenis_transaksi === 'pinjam'
                        ? 'Peminjaman Alat'
                        : 'Sewa Alat',
                    'status' => $item->status,
                    'waktu_raw' => $item->created_at,
                    'waktu' => Carbon::parse($item->created_at)->diffForHumans(),
                ];
            });

        $aktivitasKas = KasPembayaran::with('kasBulanan')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                $periodeKas = $item->kasBulanan
                    ? Carbon::create($item->kasBulanan->tahun, $item->kasBulanan->bulan, 1)->translatedFormat('F Y')
                    : null;

                return [
                    'id' => $item->id,
                    'tipe' => 'pembayaran_kas',
                    'judul' => 'Pembayaran Kas',
                    'status' => $item->status,
                    'nominal' => $item->nominal,
                    'nominal_formatted' => 'Rp ' . number_format($item->nominal, 0, ',', '.'),
                    'periode_kas' => $periodeKas,
                    'waktu_raw' => $item->created_at,
                    'waktu' => Carbon::parse($item->created_at)->diffForHumans(),
                ];
            });

        $aktivitas = $aktivitasTransaksi
            ->concat($aktivitasKas)
            ->sortByDesc('waktu_raw')
            ->take(10)
            ->values()
            ->map(function ($item) {
                unset($item['waktu_raw']);

                return $item;
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

<?php

namespace App\Http\Controllers\APi\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiAlat;
use App\Models\DetailTransaksi;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PinjamController extends Controller
{
    public function index()
{
    $transaksis = TransaksiAlat::with([
            'detailTransaksis.alat'
        ])
        ->where('user_id', Auth::id())
        ->orderBy('id', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'Riwayat transaksi',
        'data' => $transaksis,
    ]);
}

public function show($id)
{
    $transaksi = TransaksiAlat::with([
            'detailTransaksis.alat'
        ])
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if (! $transaksi) {
        return response()->json([
            'success' => false,
            'message' => 'Transaksi tidak ditemukan',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Detail transaksi',
        'data' => $transaksi,
    ]);
}


    /**
     * pinjam alat (gratis untuk anggota)
     */
    public function pinjam(Request $request)
    {
        $request->validate([
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'alat_ids'         => 'required|array|min:1',
            'alat_ids.*'       => 'exists:alats,id',
        ]);

        DB::beginTransaction();

        try {
            // Buat transaksi
            $transaksi = TransaksiAlat::create([
                'user_id'         => Auth::id(),
                'jenis_transaksi' => 'pinjam',
                'tanggal_ajuan'   => now()->toDateString(),
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status'          => 'menunggu',
                'total_biaya'     => 0, // GRATIS
            ]);

            // Simpan detail alat
            foreach ($request->alat_ids as $alatId) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'alat_id'      => $alatId,
                ]);

                // Optional: ubah status alat
                Alat::where('id', $alatId)->update([
                    'status' => 'dipinjam',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permintaan pinjam alat berhasil dibuat',
                'data' => [
                    'transaksi_id' => $transaksi->id,
                    'status' => $transaksi->status,
                    'total_biaya' => $transaksi->total_biaya,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

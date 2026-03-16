<?php

namespace App\Http\Controllers\APi\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiAlat;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Log::info('Pinjam: request masuk', [
            'user_id' => Auth::id(),
            'payload' => $request->all(),
        ]);

        $request->validate([
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'alat_ids'         => 'required|array|min:1',
            'alat_ids.*'       => 'exists:alats,id',
        ]);

        Log::info('Pinjam: validasi lolos', [
            'alat_ids'        => $request->alat_ids,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
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
                'total_biaya'     => 0,
            ]);

            Log::info('Pinjam: transaksi dibuat', ['transaksi_id' => $transaksi->id]);

            // Simpan detail alat
            foreach ($request->alat_ids as $alatId) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'alat_id'      => $alatId,
                ]);

                Alat::where('id', $alatId)->update(['status' => 'dipinjam']);

                Log::info('Pinjam: detail alat disimpan', ['alat_id' => $alatId]);
            }

            // Auto insert pembayaran settlement (pinjam = gratis)
            $pembayaran = Pembayaran::create([
                'transaksi_id'       => $transaksi->id,
                'order_id'           => 'PINJAM-' . $transaksi->id . '-' . time(),
                'gross_amount'       => 0,
                'payment_type'       => 'other',
                'transaction_status' => 'settlement',
                'settlement_time'    => now(),
                'notes'              => 'Peminjaman gratis — anggota',
            ]);

            Log::info('Pinjam: pembayaran dibuat', ['pembayaran_id' => $pembayaran->id]);

            // Update status transaksi menjadi disetujui
            $transaksi->update(['status' => 'disetujui']);

            Log::info('Pinjam: transaksi disetujui', ['transaksi_id' => $transaksi->id]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permintaan pinjam alat berhasil dibuat',
                'data' => [
                    'transaksi_id' => $transaksi->id,
                    'status'       => $transaksi->fresh()->status,
                    'total_biaya'  => $transaksi->total_biaya,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Pinjam: gagal', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}

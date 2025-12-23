<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KasPembayaran;
use App\Models\KasBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KasPembayaranController extends Controller
{
    /**
     * List pembayaran kas user
     */
    public function index(Request $request)
    {
        $data = KasPembayaran::with('kasBulanan')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Simpan pembayaran kas (upload bukti)
     */
    public function store(Request $request)
    {
        $request->validate([
            'kas_bulanan_id' => 'required|exists:kas_bulanans,id',
            'nominal' => 'required|numeric|min:1000',
            'metode' => 'required|in:dana,cash',
            'bukti_bayar' => 'nullable|image|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $kas = KasBulanan::where('id', $request->kas_bulanan_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $path = null;
        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('kas/bukti', 'public');
        }

        $pembayaran = KasPembayaran::create([
            'kas_bulanan_id' => $kas->id,
            'user_id' => $request->user()->id,
            'nominal' => $request->nominal,
            'metode' => $request->metode,
            'bukti_bayar' => $path,
            'status' => 'menunggu',
            'tanggal_bayar' => now(),
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran kas berhasil dikirim, menunggu verifikasi',
            'data' => $pembayaran,
        ], 201);
    }

    /**
     * Detail pembayaran
     */
    public function show($id, Request $request)
    {
        $data = KasPembayaran::with('kasBulanan')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}

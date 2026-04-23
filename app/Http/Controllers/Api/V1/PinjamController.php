<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiAlat;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PinjamController extends Controller
{
    public function index()
    {
        $transaksis = TransaksiAlat::withCount('detailTransaksis')
        ->where('user_id', Auth::id())
        ->where('jenis_transaksi', 'pinjam')
        ->orderBy('id', 'desc')
        ->get()
        ->map(fn (TransaksiAlat $transaksi) => [
            'id' => $transaksi->id,
            'jenis_transaksi' => $transaksi->jenis_transaksi,
            'tanggal_ajuan' => $transaksi->tanggal_ajuan?->toDateString(),
            'tanggal_pinjam' => $transaksi->tanggal_pinjam?->toDateString(),
            'tanggal_kembali' => $transaksi->tanggal_kembali?->toDateString(),
            'status' => $transaksi->status,
            'total_biaya' => $transaksi->total_biaya,
            'jumlah_alat' => $transaksi->detail_transaksis_count,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pinjam alat',
            'data' => $transaksis,
        ]);
    }

    public function show($id)
    {
        $transaksi = TransaksiAlat::with([
            'detailTransaksis.alat',
            'pembayaran',
        ])
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->where('jenis_transaksi', 'pinjam')
        ->first();

        if (! $transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pinjam alat',
            'data' => [
                'id' => $transaksi->id,
                'jenis_transaksi' => $transaksi->jenis_transaksi,
                'tanggal_ajuan' => $transaksi->tanggal_ajuan?->toDateString(),
                'tanggal_pinjam' => $transaksi->tanggal_pinjam?->toDateString(),
                'tanggal_kembali' => $transaksi->tanggal_kembali?->toDateString(),
                'status' => $transaksi->status,
                'total_biaya' => $transaksi->total_biaya,
                'jumlah_alat' => $transaksi->detailTransaksis->count(),
                'pembayaran' => $transaksi->pembayaran ? [
                    'id' => $transaksi->pembayaran->id,
                    'order_id' => $transaksi->pembayaran->order_id,
                    'gross_amount' => $transaksi->pembayaran->gross_amount,
                    'payment_type' => $transaksi->pembayaran->payment_type,
                    'transaction_status' => $transaksi->pembayaran->transaction_status,
                    'settlement_time' => $transaksi->pembayaran->settlement_time?->toDateTimeString(),
                    'notes' => $transaksi->pembayaran->notes,
                ] : null,
                'alats' => $transaksi->detailTransaksis->map(fn (DetailTransaksi $detail) => [
                    'detail_id' => $detail->id,
                    'alat_id' => $detail->alat_id,
                    'kode_alat' => $detail->alat?->kode_alat,
                    'nama_alat' => $detail->alat?->nama_alat,
                    'ukuran' => $detail->alat?->ukuran,
                    'bahan' => $detail->alat?->bahan,
                    'image' => $detail->alat?->image,
                    'harga_sewa' => $detail->alat?->harga_sewa,
                    'status_alat' => $detail->alat?->status,
                    'kondisi_kembali' => $detail->kondisi_kembali,
                    'denda_telat' => $detail->denda_telat,
                    'denda_rusak' => $detail->denda_rusak,
                    'total_denda' => $detail->total_denda,
                    'keterangan' => $detail->keterangan,
                    'foto_kembali' => $detail->foto_kembali,
                ])->values(),
            ],
        ]);
    }

    /**
     * pinjam alat (gratis untuk anggota)
     *
     * Format yang didukung:
     * - alat_id + jumlah, seperti form alat di welcome.blade.php
     * - items: [{ alat_id, jumlah }], untuk beberapa jenis alat
     * - alat_ids: [1, 2, 3], format lama untuk memilih unit spesifik
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
            'alat_id'          => 'nullable|integer|exists:alats,id',
            'jumlah'           => 'nullable|integer|min:1',
            'items'            => 'nullable|array|min:1',
            'items.*.alat_id'  => 'required_with:items|integer|exists:alats,id',
            'items.*.jumlah'   => 'required_with:items|integer|min:1',
            'alat_ids'         => 'nullable|array|min:1',
            'alat_ids.*'       => 'integer|exists:alats,id',
        ]);

        if (! $request->filled('alat_id') && ! $request->filled('items') && ! $request->filled('alat_ids')) {
            throw ValidationException::withMessages([
                'alat' => 'Pilih minimal satu alat untuk dipinjam.',
            ]);
        }

        Log::info('Pinjam: validasi lolos', [
            'alat_id'         => $request->alat_id,
            'jumlah'          => $request->jumlah,
            'items'           => $request->items,
            'alat_ids'        => $request->alat_ids,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        DB::beginTransaction();

        try {
            $alats = $this->resolveAlatPinjaman($request);

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
            foreach ($alats as $alat) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'alat_id'      => $alat->id,
                ]);

                $alat->update(['status' => 'dipinjam']);

                Log::info('Pinjam: detail alat disimpan', ['alat_id' => $alat->id]);
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
                    'jumlah_alat'  => $alats->count(),
                    'alat_ids'     => $alats->pluck('id')->values(),
                ],
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();

            throw $e;
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

    /**
     * Ambil unit fisik yang tersedia.
     *
     * Jika request berisi alat_id + jumlah, alat_id dipakai sebagai contoh jenis
     * alat, lalu sistem mengambil unit tersedia lain dengan nama_alat yang sama.
     */
    private function resolveAlatPinjaman(Request $request)
    {
        $selected = collect();
        $selectedIds = [];

        foreach ($request->input('alat_ids', []) as $alatId) {
            if (in_array((int) $alatId, $selectedIds, true)) {
                throw ValidationException::withMessages([
                    'alat_ids' => 'Alat yang sama tidak boleh dipilih lebih dari satu kali.',
                ]);
            }

            $alat = Alat::whereKey($alatId)
                ->lockForUpdate()
                ->first();

            if (! $alat || $alat->status !== 'tersedia') {
                throw ValidationException::withMessages([
                    'alat_ids' => 'Salah satu alat yang dipilih sedang tidak tersedia.',
                ]);
            }

            $selected->push($alat);
            $selectedIds[] = (int) $alat->id;
        }

        $requests = [];

        if ($request->filled('alat_id')) {
            $requests[] = [
                'alat_id' => (int) $request->input('alat_id'),
                'jumlah'  => (int) $request->input('jumlah', 1),
            ];
        }

        foreach ($request->input('items', []) as $item) {
            $requests[] = [
                'alat_id' => (int) $item['alat_id'],
                'jumlah'  => (int) $item['jumlah'],
            ];
        }

        foreach ($requests as $item) {
            $contohAlat = Alat::find($item['alat_id']);
            $jumlah = max(1, (int) $item['jumlah']);

            if (! $contohAlat) {
                throw ValidationException::withMessages([
                    'alat_id' => 'Alat tidak ditemukan.',
                ]);
            }

            $unitTersedia = Alat::where('nama_alat', $contohAlat->nama_alat)
                ->where('status', 'tersedia')
                ->whereNotIn('id', $selectedIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->take($jumlah)
                ->get();

            if ($unitTersedia->count() < $jumlah) {
                throw ValidationException::withMessages([
                    'jumlah' => "Stok {$contohAlat->nama_alat} tidak mencukupi. Tersedia hanya {$unitTersedia->count()} unit.",
                ]);
            }

            foreach ($unitTersedia as $alat) {
                $selected->push($alat);
                $selectedIds[] = (int) $alat->id;
            }
        }

        if ($selected->isEmpty()) {
            throw ValidationException::withMessages([
                'alat' => 'Pilih minimal satu alat untuk dipinjam.',
            ]);
        }

        return $selected;
    }
}

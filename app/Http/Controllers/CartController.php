<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang
     */
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $total_per_hari = array_sum(array_column($cart, 'harga_sewa'));

        // Ambil tanggal dari query string (jika ada)
        $tanggal_pinjam = $request->get('tanggal_pinjam');
        $tanggal_kembali = $request->get('tanggal_kembali');

        $data = [
            'cart' => $cart,
            'total_per_hari' => $total_per_hari,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
        ];

        // Hitung otomatis jika kedua tanggal tersedia
        if ($tanggal_pinjam && $tanggal_kembali) {
            try {
                $start = new \Carbon\Carbon($tanggal_pinjam);
                $end = new \Carbon\Carbon($tanggal_kembali);
                
                // Validasi tanggal
                if ($start->isPast() && !$start->isToday()) {
                    $data['error'] = 'Tanggal pinjam tidak boleh kurang dari hari ini.';
                } elseif ($end->lte($start)) {
                    $data['error'] = 'Tanggal kembali harus setelah tanggal pinjam.';
                } else {
                    $days = $start->diffInDays($end);
                    
                    if ($days < 1) {
                        $data['error'] = 'Durasi penyewaan minimal 1 hari.';
                    } else {
                        $data['durasi'] = $days;
                        $data['total_biaya'] = $total_per_hari * $days;
                    }
                }
            } catch (\Exception $e) {
                $data['error'] = 'Format tanggal tidak valid.';
            }
        }

        return view('cart.index', $data);
    }

    /**
     * Tambah alat ke keranjang
     */
    public function add(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah'  => 'required|integer|min:1',
        ]);

        $alat   = Alat::findOrFail($request->alat_id);
        $jumlah = (int) $request->jumlah;

        // Ambil semua unit tersedia dengan nama_alat yang sama
        $unitTersedia = Alat::where('nama_alat', $alat->nama_alat)
            ->where('status', 'tersedia')
            ->take($jumlah)
            ->get();

        if ($unitTersedia->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Alat sedang tidak tersedia.')
                ->withFragment('equipment');
        }

        if ($unitTersedia->count() < $jumlah) {
            return redirect()->back()
                ->with('error', "Stok tidak mencukupi. Tersedia hanya {$unitTersedia->count()} unit.")
                ->withFragment('equipment');
        }

        $cart  = session()->get('cart', []);
        $added = 0;

        foreach ($unitTersedia as $unit) {
            if (!isset($cart[$unit->id])) {
                $cart[$unit->id] = [
                    'id'         => $unit->id,
                    'kode_alat'  => $unit->kode_alat,
                    'nama_alat'  => $unit->nama_alat,
                    'harga_sewa' => $unit->harga_sewa,
                ];
                $added++;
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', "{$added} unit {$alat->nama_alat} berhasil ditambahkan ke keranjang!")
            ->withFragment('equipment');
    }

    /**
     * Hapus alat dari keranjang
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Alat berhasil dihapus dari keranjang.');
    }

    /**
     * Checkout - Create payment from cart
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        // Validasi tanggal
        $request->validate([
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'total_biaya' => 'required|numeric|min:0',
        ], [
            'tanggal_pinjam.required' => 'Tanggal pinjam harus diisi',
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh di masa lalu',
            'tanggal_kembali.required' => 'Tanggal kembali harus diisi',
            'tanggal_kembali.after' => 'Tanggal kembali harus setelah tanggal pinjam',
        ]);

        // Redirect ke PaymentController untuk proses pembayaran
        return app(PaymentController::class)->create($request);
    }
}

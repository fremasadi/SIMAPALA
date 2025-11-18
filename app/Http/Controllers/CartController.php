<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\TransaksiAlat;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        // total harga per hari (tanpa durasi)
        $total_per_hari = array_sum(array_column($cart, 'harga_sewa'));

        return view('cart.index', compact('cart', 'total_per_hari'));
    }

    /**
     * Tambah alat ke keranjang
     */
    public function add(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id'
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$alat->id])) {
            return redirect()->back()
                ->with('info', 'Alat sudah ada di keranjang.')
                ->withFragment('equipment');
        }

        $cart[$alat->id] = [
            'id'         => $alat->id,
            'kode_alat'  => $alat->kode_alat,
            'nama_alat'  => $alat->nama_alat,
            'harga_sewa' => $alat->harga_sewa
        ];

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Alat berhasil ditambahkan ke keranjang!')
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
     * Hitung total biaya penyewaan
     */
    public function calculate(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong!');
        }

        $validated = $request->validate([
            'tanggal_pinjam'  => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam'
        ], [
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh kurang dari hari ini.',
            'tanggal_kembali.after'         => 'Tanggal kembali harus setelah tanggal pinjam.'
        ]);

        $start = new \Carbon\Carbon($validated['tanggal_pinjam']);
        $end   = new \Carbon\Carbon($validated['tanggal_kembali']);

        $days = $start->diffInDays($end);

        // Minimal 1 hari
        if ($days < 1) {
            return back()->with('error', 'Durasi penyewaan minimal 1 hari.');
        }

        $total_per_hari = array_sum(array_column($cart, 'harga_sewa'));
        $total_biaya    = $total_per_hari * $days;

        return view('cart.index', [
            'cart'            => $cart,
            'total_per_hari'  => $total_per_hari,
            'total_biaya'     => $total_biaya,
            'tanggal_pinjam'  => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'durasi'          => $days
        ]);
    }

    /**
     * Proses checkout dan buat transaksi
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kosong. Silakan tambahkan alat terlebih dahulu.');
        }

        // Validasi input
        $validated = $request->validate([
            'tanggal_pinjam'  => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'total_biaya'     => 'required|numeric|min:0',
        ], [
            'tanggal_pinjam.required'       => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh kurang dari hari ini.',
            'tanggal_kembali.required'      => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.after'         => 'Tanggal kembali harus setelah tanggal pinjam.',
            'total_biaya.required'          => 'Total biaya tidak valid.',
            'total_biaya.min'               => 'Total biaya tidak valid.',
        ]);

        try {
            DB::beginTransaction();

            // Buat transaksi
            $transaksi = TransaksiAlat::create([
                'user_id'         => auth()->id(),
                'jenis_transaksi' => 'sewa',
                'tanggal_ajuan'   => now(),
                'tanggal_pinjam'  => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status'          => 'menunggu',
                'total_biaya'     => $validated['total_biaya'],
            ]);

            // Buat detail transaksi untuk setiap alat
            foreach ($cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id'    => $transaksi->id,
                    'alat_id'         => $item['id'],
                    'kondisi_kembali' => null,
                ]);
            }

            // Hapus keranjang setelah berhasil
            session()->forget('cart');

            DB::commit();

            // Redirect ke halaman pembayaran
            return redirect()->route('payment.create', $transaksi->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            Log::error('Checkout error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'cart'    => $cart,
                'request' => $request->all()
            ]);
            
            return redirect()->route('cart.index')
                ->with('error', 'Gagal membuat pesanan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DanaMasuk;
use App\Models\KasPembayaran;
use App\Models\KasBulanan;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasPembayaranController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

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
     * Buat pembayaran kas via Midtrans Snap.
     */
    public function store(Request $request)
    {
        if ($request->keterangan === '') {
            $request->merge(['keterangan' => null]);
        }

        $validated = $request->validate([
            'kas_bulanan_id' => 'required|exists:kas_bulanans,id',
            'nominal'        => 'required|numeric|min:1000',
            'keterangan'     => 'nullable|string',
        ]);

        $user = $request->user();
        $kas = KasBulanan::where('id', $validated['kas_bulanan_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $existingPending = KasPembayaran::where('kas_bulanan_id', $kas->id)
            ->where('user_id', $user->id)
            ->where('status', 'menunggu')
            ->whereNotNull('order_id')
            ->latest()
            ->first();

        if ($existingPending) {
            $statusResult = $this->midtrans->getTransactionStatus($existingPending->order_id);

            if ($statusResult['success']) {
                $this->updatePaymentStatus($existingPending, $statusResult['data']);
                $existingPending->refresh();
            }

            if ($existingPending->status === 'menunggu') {
                return response()->json([
                    'success' => true,
                    'message' => 'Masih ada pembayaran kas yang menunggu pembayaran',
                    'data' => $existingPending->load('kasBulanan'),
                    'payment_url' => $existingPending->payment_url,
                    'snap_token' => $existingPending->snap_token,
                    'order_id' => $existingPending->order_id,
                ]);
            }
        }

        $totalDiterima = (float) $kas->pembayarans()
            ->where('status', 'diterima')
            ->sum('nominal');
        $sisaTagihan = max(0, (float) $kas->nominal - $totalDiterima);
        $nominal = (int) $validated['nominal'];

        if ($sisaTagihan <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kas bulanan ini sudah lunas',
            ], 422);
        }

        if ($nominal > $sisaTagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Nominal melebihi sisa tagihan kas',
                'sisa_tagihan' => $sisaTagihan,
            ], 422);
        }

        $orderId = 'KAS-' . $kas->id . '-' . $user->id . '-' . time();
        $customerDetails = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? $user->no_hp ?? '08123456789',
        ];
        $itemDetails = [[
            'id' => 'KAS-' . $kas->id,
            'price' => $nominal,
            'quantity' => 1,
            'name' => 'Kas Bulanan ' . $kas->bulan . '/' . $kas->tahun,
        ]];

        DB::beginTransaction();

        try {
            $result = $this->midtrans->createTransaction(
                $orderId,
                $nominal,
                $customerDetails,
                $itemDetails,
                route('kas-pembayaran.finish')
            );

            if (!$result['success']) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat pembayaran Midtrans: ' . $result['message'],
                ], 500);
            }

            $pembayaran = KasPembayaran::create([
                'kas_bulanan_id' => $kas->id,
                'user_id' => $user->id,
                'nominal' => $nominal,
                'metode' => 'dana',
                'bukti_bayar' => null,
                'status' => 'menunggu',
                'tanggal_bayar' => now(),
                'keterangan' => $validated['keterangan'] ?? null,
                'order_id' => $orderId,
                'transaction_status' => 'pending',
                'payment_url' => $result['payment_url'],
                'snap_token' => $result['snap_token'],
                'midtrans_response' => $result,
            ]);

            DB::commit();

            Log::info('KasPembayaran: pembayaran Midtrans dibuat', [
                'pembayaran_id' => $pembayaran->id,
                'order_id' => $orderId,
                'nominal' => $nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran kas berhasil dibuat',
                'data' => $pembayaran->load('kasBulanan'),
                'payment_url' => $result['payment_url'],
                'snap_token' => $result['snap_token'],
                'order_id' => $orderId,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('KasPembayaran: gagal membuat pembayaran Midtrans', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
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

    /**
     * Callback publik dari Midtrans untuk pembayaran kas.
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $pembayaran = KasPembayaran::where('order_id', $request->order_id)->first();

        if (!$pembayaran) {
            return response()->json(['message' => 'Kas payment not found'], 404);
        }

        $this->updatePaymentStatus($pembayaran, $request->all());

        return response()->json(['message' => 'Kas payment callback processed']);
    }

    /**
     * Finish URL dari Snap.
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $pembayaran = KasPembayaran::where('order_id', $orderId)->first();

        if (!$pembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran kas tidak ditemukan',
            ], 404);
        }

        $statusResult = $this->midtrans->getTransactionStatus($orderId);

        if ($statusResult['success']) {
            $this->updatePaymentStatus($pembayaran, $statusResult['data']);
            $pembayaran->refresh();
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pembayaran kas diperbarui',
            'data' => $pembayaran->load('kasBulanan'),
        ]);
    }

    /**
     * Cek status pembayaran kas dari aplikasi.
     */
    public function checkStatus($id, Request $request)
    {
        $pembayaran = KasPembayaran::with('kasBulanan')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        if (!$pembayaran->order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran ini belum memiliki order Midtrans',
            ], 422);
        }

        $statusResult = $this->midtrans->getTransactionStatus($pembayaran->order_id);

        if (!$statusResult['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek status pembayaran: ' . ($statusResult['message'] ?? 'Unknown error'),
            ], 500);
        }

        $this->updatePaymentStatus($pembayaran, $statusResult['data']);
        $pembayaran->refresh();

        return response()->json([
            'success' => true,
            'status' => $pembayaran->status,
            'transaction_status' => $pembayaran->transaction_status,
            'data' => $pembayaran->load('kasBulanan'),
        ]);
    }

    public function updateFromMidtransNotification(KasPembayaran $pembayaran, array $data): void
    {
        $this->updatePaymentStatus($pembayaran, $data);
    }

    private function updatePaymentStatus(KasPembayaran $pembayaran, $data): void
    {
        $data = is_array($data) ? $data : json_decode(json_encode($data), true);

        $transactionStatus = $data['transaction_status'] ?? 'pending';
        $fraudStatus = $data['fraud_status'] ?? null;
        $paymentType = $data['payment_type'] ?? null;

        $updateData = [
            'transaction_id' => $data['transaction_id'] ?? $pembayaran->transaction_id,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_type' => $paymentType,
            'midtrans_response' => $data,
        ];

        if (!empty($data['va_numbers'])) {
            $vaNumber = $data['va_numbers'][0];
            $updateData['bank'] = $vaNumber['bank'] ?? null;
            $updateData['va_number'] = $vaNumber['va_number'] ?? null;
        }

        if ($paymentType === 'qris' && !empty($data['acquirer'])) {
            $updateData['bank'] = $data['acquirer'];
        }

        if (!empty($data['transaction_time'])) {
            $updateData['transaction_time'] = $data['transaction_time'];
        }

        DB::transaction(function () use ($pembayaran, $transactionStatus, $updateData) {
            $pembayaran->loadMissing(['kasBulanan', 'user']);

            if (in_array($transactionStatus, ['settlement', 'capture'], true)) {
                $updateData['status'] = 'diterima';
                $updateData['verified_at'] = $pembayaran->verified_at ?? now();
                $updateData['settlement_time'] = $pembayaran->settlement_time ?? now();
                $updateData['tanggal_bayar'] = now();
            }

            if (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'], true)) {
                $updateData['status'] = 'ditolak';
                $updateData['verified_at'] = $pembayaran->verified_at ?? now();
            }

            $pembayaran->update($updateData);

            if ($pembayaran->kasBulanan) {
                $pembayaran->kasBulanan->updateStatus();
            }

            if ($pembayaran->status !== 'diterima') {
                return;
            }

            $sudahAda = DanaMasuk::where('sumber_type', KasPembayaran::class)
                ->where('sumber_id', $pembayaran->id)
                ->where('jenis', 'kas')
                ->exists();

            if (!$sudahAda) {
                DanaMasuk::create([
                    'jenis' => 'kas',
                    'nominal' => $pembayaran->nominal,
                    'status' => 'approved',
                    'keterangan' => "Kas bulanan - {$pembayaran->user->name}",
                    'tanggal' => now()->toDateString(),
                    'user_id' => $pembayaran->user_id,
                    'sumber_type' => KasPembayaran::class,
                    'sumber_id' => $pembayaran->id,
                ]);
            }
        });
    }
}

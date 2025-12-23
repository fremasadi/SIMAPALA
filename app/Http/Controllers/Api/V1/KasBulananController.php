<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KasBulanan;
use App\Models\KasPembayaran;
use Illuminate\Http\Request;

class KasBulananController extends Controller
{
    /**
     * List kas bulanan user login
     */
    public function index(Request $request)
    {
        $data = KasBulanan::with('pembayarans')
            ->where('user_id', $request->user()->id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Detail kas bulanan
     */
    public function show($id, Request $request)
    {
        $kas = KasBulanan::with('pembayarans')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $kas,
        ]);
    }

    /**
 * Total kas anggota yang sedang login
 */
public function totalKas(Request $request)
{
    $user = $request->user();

    $total = KasPembayaran::where('user_id', $user->id)
        ->where('status', 'diterima')
        ->sum('nominal');

    return response()->json([
        'success' => true,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
        ],
        'total_kas' => $total,
        'formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
    ]);
}

}

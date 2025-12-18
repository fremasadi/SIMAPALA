<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiAlat;
use App\Models\DetailTransaksi;
use App\Models\Alat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
}

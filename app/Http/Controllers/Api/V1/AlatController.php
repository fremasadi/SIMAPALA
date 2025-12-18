<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * GET /api/v1/alats
     * Menampilkan daftar alat
     */
    public function index()
    {
        $alats = Alat::orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar alat berhasil diambil',
            'data' => $alats,
        ], 200);
    }

    /**
     * GET /api/v1/alats/{id}
     * Detail alat
     */
    public function show($id)
    {
        $alat = Alat::find($id);

        if (! $alat) {
            return response()->json([
                'success' => false,
                'message' => 'Alat tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail alat',
            'data' => $alat,
        ], 200);
    }
}

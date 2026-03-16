<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DanaMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DanaMasukController extends Controller
{
    /**
     * Get semua data dana masuk (approved)
     */
    public function index(Request $request)
    {
        $query = DanaMasuk::with('user')
            ->orderByDesc('tanggal');

        // Filter by status (optional, default: semua)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by bulan & tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                  ->whereYear('tanggal', $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $data = $query->get()->map(fn ($item) => [
            'id'          => $item->id,
            'jenis'       => $item->jenis,
            'jenis_label' => $item->jenis_label,
            'nominal'     => (float) $item->nominal,
            'keterangan'  => $item->keterangan,
            'tanggal'     => $item->tanggal?->toDateString(),
            'user'        => $item->user ? [
                'id'   => $item->user->id,
                'name' => $item->user->name,
            ] : null,
        ]);

        return response()->json([
            'success' => true,
            'total'   => $data->sum('nominal'),
            'data'    => $data,
        ]);
    }

    /**
     * Submit sumbangan (status pending, menunggu verifikasi admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nominal'    => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:500',
            'bukti'      => 'nullable|image|max:2048',
            'tanggal'    => 'nullable|date',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('dana-masuk/bukti', 'public');
        }

        $dana = DanaMasuk::create([
            'jenis'      => 'sumbangan',
            'nominal'    => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal'    => $request->tanggal ?? now()->toDateString(),
            'status'     => 'pending',
            'user_id'    => $request->user()->id,
            'sumber_type' => null,
            'sumber_id'   => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sumbangan berhasil dikirim, menunggu verifikasi admin',
            'data'    => [
                'id'         => $dana->id,
                'jenis'      => $dana->jenis,
                'jenis_label'=> $dana->jenis_label,
                'nominal'    => (float) $dana->nominal,
                'keterangan' => $dana->keterangan,
                'tanggal'    => $dana->tanggal?->toDateString(),
                'status'     => $dana->status,
            ],
        ], 201);
    }

    /**
     * Summary total per jenis
     */
    public function summary(Request $request)
    {
        $query = DanaMasuk::where('status', 'approved');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $summary = $query->get()
            ->groupBy('jenis')
            ->map(fn ($items, $jenis) => [
                'jenis'       => $jenis,
                'jenis_label' => DanaMasuk::JENIS[$jenis] ?? ucfirst($jenis),
                'total'       => $items->sum(fn ($i) => (float) $i->nominal),
                'count'       => $items->count(),
            ])
            ->values();

        return response()->json([
            'success'     => true,
            'grand_total' => $summary->sum('total'),
            'data'        => $summary,
        ]);
    }
}

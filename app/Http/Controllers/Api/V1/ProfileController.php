<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Fetch profile user berdasarkan token
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('anggota');

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update profile user berdasarkan token
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name'   => 'sometimes|string|max:255',
            'email'  => 'sometimes|email|unique:users,email,' . $user->id,
            'no_hp'  => 'sometimes|string|max:20',
            'alamat' => 'sometimes|string',
            'password' => 'sometimes|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $request->only([
            'name',
            'email',
            'no_hp',
            'alamat'
        ]);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diperbarui',
            'data' => $user
        ]);
    }

    /**
     * Ganti password user
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui',
        ]);
    }

    /**
     * Get image anggota
     */
    public function getImage(Request $request)
    {
        $anggota = $request->user()->anggota;

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'Data anggota tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'image'     => $anggota->image,
                'image_url' => $anggota->image ? Storage::disk('public')->url($anggota->image) : null,
            ],
        ]);
    }

    /**
     * Update image anggota
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $anggota = $request->user()->anggota;

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'Data anggota tidak ditemukan',
            ], 404);
        }

        // Hapus gambar lama jika ada
        if ($anggota->image) {
            Storage::disk('public')->delete($anggota->image);
        }

        $path = $request->file('image')->store('anggota/images', 'public');

        $anggota->update(['image' => $path]);

        return response()->json([
            'success'   => true,
            'message'   => 'Foto profil berhasil diperbarui',
            'data' => [
                'image'     => $anggota->image,
                'image_url' => Storage::disk('public')->url($anggota->image),
            ],
        ]);
    }
}
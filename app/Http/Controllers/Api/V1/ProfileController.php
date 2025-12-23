<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
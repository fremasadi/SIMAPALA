<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAnggota extends CreateRecord
{
    protected static string $resource = AnggotaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Buat user baru
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'anggota',
        ]);

        // 2. Masukkan user_id ke anggota
        $data['user_id'] = $user->id;

        // 3. Hapus data yang tidak ada di tabel anggotas
        unset($data['name'], $data['email'], $data['password']);

        return $data;
    }
}

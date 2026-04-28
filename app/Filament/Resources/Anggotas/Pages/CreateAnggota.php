<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use App\Models\KasBulanan;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class CreateAnggota extends CreateRecord
{
    protected static string $resource = AnggotaResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $registeredAt = ! empty($data['created_at'])
            ? Carbon::parse($data['created_at'])
            : now();

        // 1. Buat user baru
        $user = new User();
        $user->forceFill([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'anggota',
            'created_at' => $registeredAt,
            'updated_at' => $registeredAt,
        ]);
        $user->save();

        // 2. Masukkan user_id ke anggota
        $data['user_id'] = $user->id;
        $data['status_keanggotaan'] = 'aktif';
        $data['created_at'] = $registeredAt;
        $data['updated_at'] = $registeredAt;

        // 3. Hapus data yang tidak ada di tabel anggotas
        unset($data['name'], $data['email'], $data['password']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $userId = $this->record->user_id;
        $now    = now();

        $kas = KasBulanan::firstOrCreate(
            [
                'user_id' => $userId,
                'bulan'   => $now->month,
                'tahun'   => $now->year,
            ],
            [
                'nominal' => 10000,
                'status'  => 'belum_lunas',
            ]
        );

        Log::info('CreateAnggota: kas bulanan bulan ini di-generate untuk user baru', [
            'user_id'  => $userId,
            'bulan'    => $now->format('Y-m'),
            'created'  => $kas->wasRecentlyCreated,
        ]);
    }
}

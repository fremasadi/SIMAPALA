<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    protected function afterCreate(): void
    {
        Log::info('CreateAnggota: afterCreate dipanggil', [
            'record_id' => $this->record->id ?? null,
            'user_id'   => $this->record->user_id ?? null,
        ]);

        try {
            $exitCode = Artisan::call('kas:generate-bulanan');
            $output   = Artisan::output();

            Log::info('CreateAnggota: kas:generate-bulanan selesai', [
                'exit_code' => $exitCode,
                'output'    => $output,
            ]);
        } catch (\Throwable $e) {
            Log::error('CreateAnggota: kas:generate-bulanan gagal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}

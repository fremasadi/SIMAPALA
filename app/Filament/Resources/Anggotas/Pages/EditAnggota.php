<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use App\Models\Anggota;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditAnggota extends EditRecord
{
    protected static string $resource = AnggotaResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->loadMissing('user');

        $data['name'] = $this->record->user?->name;
        $data['email'] = $this->record->user?->email;
        $data['password'] = null;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var Anggota $record */
        $record->loadMissing('user');

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'created_at' => $data['created_at'],
        ];

        if (filled($data['password'] ?? null)) {
            $userData['password'] = Hash::make($data['password']);
        }

        $record->user?->update($userData);

        unset($data['name'], $data['email'], $data['password']);

        $record->update($data);

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}

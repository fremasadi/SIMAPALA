<?php

namespace App\Filament\Resources\DanaKeluars\Pages;

use App\Filament\Resources\DanaKeluars\DanaKeluarResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDanaKeluar extends CreateRecord
{
    protected static string $resource = DanaKeluarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}

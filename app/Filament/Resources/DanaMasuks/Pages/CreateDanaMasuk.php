<?php

namespace App\Filament\Resources\DanaMasuks\Pages;

use App\Filament\Resources\DanaMasuks\DanaMasukResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDanaMasuk extends CreateRecord
{
    protected static string $resource = DanaMasukResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'approved';

        return $data;
    }
}

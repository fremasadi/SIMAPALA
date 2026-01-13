<?php

namespace App\Filament\Resources\TransaksiAlats\Pages;

use App\Filament\Resources\TransaksiAlats\TransaksiAlatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksiAlat extends CreateRecord
{
    protected static string $resource = TransaksiAlatResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}

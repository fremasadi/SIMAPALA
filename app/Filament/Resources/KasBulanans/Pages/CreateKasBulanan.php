<?php

namespace App\Filament\Resources\KasBulanans\Pages;

use App\Filament\Resources\KasBulanans\KasBulananResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKasBulanan extends CreateRecord
{
    protected static string $resource = KasBulananResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}

<?php

namespace App\Filament\Resources\DetailTransaksis\Pages;

use App\Filament\Resources\DetailTransaksis\DetailTransaksiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDetailTransaksi extends CreateRecord
{
    protected static string $resource = DetailTransaksiResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}

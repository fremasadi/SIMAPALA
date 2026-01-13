<?php

namespace App\Filament\Resources\KasPembayarans\Pages;

use App\Filament\Resources\KasPembayarans\KasPembayaranResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKasPembayaran extends CreateRecord
{
    protected static string $resource = KasPembayaranResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }

    protected function afterSave(): void
{
    $this->record->kasBulanan?->updateStatus();
}

}

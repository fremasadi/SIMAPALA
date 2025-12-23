<?php

namespace App\Filament\Resources\KasPembayarans\Pages;

use App\Filament\Resources\KasPembayarans\KasPembayaranResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKasPembayaran extends CreateRecord
{
    protected static string $resource = KasPembayaranResource::class;

    protected function afterSave(): void
{
    $this->record->kasBulanan?->updateStatus();
}

}

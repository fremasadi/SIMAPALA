<?php

namespace App\Filament\Resources\KasPembayarans\Pages;

use App\Filament\Resources\KasPembayarans\KasPembayaranResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKasPembayaran extends EditRecord
{
    protected static string $resource = KasPembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
{
    $this->record->kasBulanan?->updateStatus();
}

}

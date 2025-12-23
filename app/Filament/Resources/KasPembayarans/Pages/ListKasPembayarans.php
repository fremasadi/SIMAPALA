<?php

namespace App\Filament\Resources\KasPembayarans\Pages;

use App\Filament\Resources\KasPembayarans\KasPembayaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKasPembayarans extends ListRecords
{
    protected static string $resource = KasPembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

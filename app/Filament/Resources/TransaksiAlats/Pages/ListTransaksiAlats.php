<?php

namespace App\Filament\Resources\TransaksiAlats\Pages;

use App\Filament\Resources\TransaksiAlats\TransaksiAlatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransaksiAlats extends ListRecords
{
    protected static string $resource = TransaksiAlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}

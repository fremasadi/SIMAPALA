<?php

namespace App\Filament\Resources\KasBulanans\Pages;

use App\Filament\Resources\KasBulanans\KasBulananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKasBulanans extends ListRecords
{
    protected static string $resource = KasBulananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\DanaMasuks\Pages;

use App\Filament\Resources\DanaMasuks\DanaMasukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDanaMasuks extends ListRecords
{
    protected static string $resource = DanaMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

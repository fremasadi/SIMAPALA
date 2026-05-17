<?php

namespace App\Filament\Resources\Inventarises\Pages;

use App\Filament\Resources\Inventarises\InventarisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventarises extends ListRecords
{
    protected static string $resource = InventarisResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

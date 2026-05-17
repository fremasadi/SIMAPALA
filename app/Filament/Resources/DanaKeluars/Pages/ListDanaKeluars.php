<?php

namespace App\Filament\Resources\DanaKeluars\Pages;

use App\Filament\Resources\DanaKeluars\DanaKeluarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDanaKeluars extends ListRecords
{
    protected static string $resource = DanaKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}

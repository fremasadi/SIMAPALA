<?php

namespace App\Filament\Resources\DanaMasuks\Pages;

use App\Filament\Resources\DanaMasuks\DanaMasukResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDanaMasuk extends EditRecord
{
    protected static string $resource = DanaMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

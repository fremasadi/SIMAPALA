<?php

namespace App\Filament\Resources\KasBulanans\Pages;

use App\Filament\Resources\KasBulanans\KasBulananResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKasBulanan extends EditRecord
{
    protected static string $resource = KasBulananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Bahans\Pages;

use App\Filament\Resources\Bahans\BahanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBahan extends EditRecord
{
    protected static string $resource = BahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

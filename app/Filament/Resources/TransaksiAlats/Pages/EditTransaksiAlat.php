<?php

namespace App\Filament\Resources\TransaksiAlats\Pages;

use App\Filament\Resources\TransaksiAlats\TransaksiAlatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaksiAlat extends EditRecord
{
    protected static string $resource = TransaksiAlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

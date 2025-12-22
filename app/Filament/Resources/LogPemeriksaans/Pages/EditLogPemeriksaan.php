<?php

namespace App\Filament\Resources\LogPemeriksaans\Pages;

use App\Filament\Resources\LogPemeriksaans\LogPemeriksaanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLogPemeriksaan extends EditRecord
{
    protected static string $resource = LogPemeriksaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

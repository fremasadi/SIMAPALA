<?php

namespace App\Filament\Resources\LogPemeriksaans\Pages;

use App\Filament\Resources\LogPemeriksaans\LogPemeriksaanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogPemeriksaans extends ListRecords
{
    protected static string $resource = LogPemeriksaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

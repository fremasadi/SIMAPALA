<?php

namespace App\Filament\Resources\TransaksiAlats\Pages;

use App\Filament\Resources\TransaksiAlats\TransaksiAlatResource;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaksiAlat extends ViewRecord
{
    protected static string $resource = TransaksiAlatResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

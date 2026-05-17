<?php

namespace App\Filament\Resources\Inventarises\Pages;

use App\Filament\Resources\Inventarises\InventarisResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInventaris extends CreateRecord
{
    protected static string $resource = InventarisResource::class;

    protected function afterCreate(): void
    {
        if ((float) $this->record->harga_perolehan <= 0) {
            return;
        }

        $this->record->danaKeluar()->create([
            'jenis' => 'pembelian_inventaris',
            'nominal' => $this->record->harga_perolehan,
            'tanggal' => $this->record->tanggal_perolehan,
            'keterangan' => "Pembelian inventaris — {$this->record->nama_barang}",
            'user_id' => Auth::id(),
        ]);
    }
}

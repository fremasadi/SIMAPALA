<?php

namespace App\Filament\Resources\Inventarises\Pages;

use App\Filament\Resources\Inventarises\InventarisResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditInventaris extends EditRecord
{
    protected static string $resource = InventarisResource::class;

    protected function afterSave(): void
    {
        if ((float) $this->record->harga_perolehan <= 0) {
            $this->record->danaKeluar()->delete();
            return;
        }

        $this->record->danaKeluar()->updateOrCreate([], [
            'jenis' => 'pembelian_inventaris',
            'nominal' => $this->record->harga_perolehan,
            'tanggal' => $this->record->tanggal_perolehan,
            'keterangan' => "Pembelian inventaris — {$this->record->nama_barang}",
            'user_id' => $this->record->danaKeluar?->user_id ?? Auth::id(),
        ]);
    }
}

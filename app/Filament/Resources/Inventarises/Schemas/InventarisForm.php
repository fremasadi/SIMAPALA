<?php

namespace App\Filament\Resources\Inventarises\Schemas;

use App\Models\Inventaris;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventarisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('kode_inventaris')
                ->label('Kode Inventaris')
                ->required()
                ->default(function () {
                    $last = Inventaris::where('kode_inventaris', 'like', 'INV%')
                        ->orderByRaw('CAST(SUBSTRING(kode_inventaris, 4) AS UNSIGNED) DESC')
                        ->value('kode_inventaris');

                    $number = $last ? (int) substr($last, 3) + 1 : 1;

                    return 'INV' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }),
            TextInput::make('nama_barang')
                ->label('Nama Barang')
                ->required(),
            TextInput::make('kategori')
                ->label('Kategori'),
            TextInput::make('jumlah')
                ->numeric()
                ->minValue(1)
                ->default(1)
                ->required(),
            Select::make('kondisi')
                ->options([
                    'baik' => 'Baik',
                    'rusak_ringan' => 'Rusak Ringan',
                    'rusak_berat' => 'Rusak Berat',
                ])
                ->default('baik')
                ->required(),
            DatePicker::make('tanggal_perolehan')
                ->label('Tanggal Perolehan')
                ->default(now())
                ->required(),
            TextInput::make('harga_perolehan')
                ->label('Harga Perolehan')
                ->numeric()
                ->default(0)
                ->required(),
            TextInput::make('sumber_dana')
                ->label('Sumber Dana'),
            Textarea::make('keterangan')
                ->columnSpanFull(),
        ]);
    }
}

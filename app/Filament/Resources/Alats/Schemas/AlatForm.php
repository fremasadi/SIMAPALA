<?php

namespace App\Filament\Resources\Alats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AlatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_alat')
                    ->required(),
                TextInput::make('nama_alat')
                    ->required(),
                Select::make('status')
                    ->options(['tersedia' => 'Tersedia', 'dipinjam' => 'Dipinjam', 'rusak' => 'Rusak', 'hilang' => 'Hilang'])
                    ->default('tersedia')
                    ->required(),
                TextInput::make('harga_sewa')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}

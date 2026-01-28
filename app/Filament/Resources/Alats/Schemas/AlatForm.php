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
                    ->label('Kode Alat')
                    ->required(),
                TextInput::make('nama_alat')
                    ->label('Nama Alat')
                    ->required(),
                TextInput::make('ukuran')
                    ->label('Ukuran'),
                TextInput::make('bahan')
                    ->label('Bahan'),
                Select::make('status')
                    ->options(['tersedia' => 'Tersedia', 'dipinjam' => 'Dipinjam', 'rusak' => 'Rusak', 'hilang' => 'Hilang'])
                    ->default('tersedia')
                    ->required(),
                TextInput::make('harga_sewa')
                    ->label('Harga Sewa')
                    ->required()
                    ->numeric()
                    ->default(0),
                    FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->directory('alats')
                    ->imageEditor(),
            ]);
    }
}
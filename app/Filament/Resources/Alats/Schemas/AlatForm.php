<?php

namespace App\Filament\Resources\Alats\Schemas;

use App\Models\Alat;
use App\Models\Bahan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class AlatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_alat')
                    ->label('Kode Alat')
                    ->required()
                    ->default(function () {
                        $last = Alat::where('kode_alat', 'like', 'AL%')
                            ->orderByRaw('CAST(SUBSTRING(kode_alat, 3) AS UNSIGNED) DESC')
                            ->value('kode_alat');

                        if ($last) {
                            $number = (int) substr($last, 2);
                            return 'AL' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
                        }

                        return 'AL001';
                    })
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('nama_alat')
                    ->label('Nama Alat')
                    ->required(),
                TextInput::make('ukuran')
                    ->label('Ukuran'),
                Select::make('bahan')
                    ->label('Bahan')
                    ->multiple()
                    ->options(fn () => Bahan::orderBy('name')->pluck('name', 'name'))
                    ->searchable()
                    ->preload(),
                Select::make('status')
                    ->options(['tersedia' => 'Tersedia', 'dipinjam' => 'Dipinjam', 'rusak' => 'Rusak', 'hilang' => 'Hilang'])
                    ->default('tersedia')
                    ->required(),
                TextInput::make('harga_alat')
                    ->label('Harga Alat')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('harga_sewa')
                    ->label('Harga Sewa')
                    ->required()
                    ->numeric()
                    ->default(0),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('alats')
                    ->imageEditor(),
            ]);
    }
}

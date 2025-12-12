<?php

namespace App\Filament\Resources\DetailTransaksis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DetailTransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('transaksi_id')
                    ->relationship('transaksi', 'id')
                    ->required(),
                Select::make('alat_id')
                    ->relationship('alat', 'id')
                    ->required(),
                TextInput::make('kondisi_kembali')
                    ->default(null),
            ]);
    }
}

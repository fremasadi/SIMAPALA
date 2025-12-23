<?php

namespace App\Filament\Resources\KasBulanans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KasBulananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('bulan')
                    ->required()
                    ->numeric(),
                TextInput::make('tahun')
                    ->required()
                    ->numeric(),
                TextInput::make('nominal')
                    ->required()
                    ->numeric()
                    ->default(10000),
                Select::make('status')
                    ->options(['belum_lunas' => 'Belum lunas', 'lunas' => 'Lunas'])
                    ->default('belum_lunas')
                    ->required(),
            ]);
    }
}

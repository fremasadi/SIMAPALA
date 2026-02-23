<?php

namespace App\Filament\Resources\Bahans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BahanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Bahan')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(255),
            ]);
    }
}

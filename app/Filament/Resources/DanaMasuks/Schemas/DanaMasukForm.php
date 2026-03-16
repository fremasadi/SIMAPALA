<?php

namespace App\Filament\Resources\DanaMasuks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DanaMasukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis')
                    ->options([
            // 'penyewaan' => 'Penyewaan',
            // 'denda_telat' => 'Denda telat',
            // 'denda_rusak' => 'Denda rusak',
            // 'kas' => 'Kas',
            'sumbangan' => 'Sumbangan',
        ])
                    ->required(),
                TextInput::make('nominal')
                    ->required()
                    ->numeric(),
                TextInput::make('keterangan')
                    ->default(null),
                DatePicker::make('tanggal')
                    ->required(),
                Select::make('user_id')
                    ->label('(Optisional) Dari User')
                    ->relationship('user', 'name')
                    ->default(null),
                // TextInput::make('sumber_type')
                //     ->default(null),
                // TextInput::make('sumber_id')
                //     ->numeric()
                //     ->default(null),
            ]);
    }
}

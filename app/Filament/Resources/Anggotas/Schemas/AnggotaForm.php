<?php

namespace App\Filament\Resources\Anggotas\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Anggota')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),

                TextInput::make('nim')
                    ->required(),

                DateTimePicker::make('created_at')
                    ->label('Didaftarkan Pada')
                    ->dehydrated(false),

                // Select::make('status_keanggotaan')
                //     ->options(['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'])
                //     ->default('aktif')
                //     ->required(),
            ]);
    }
}

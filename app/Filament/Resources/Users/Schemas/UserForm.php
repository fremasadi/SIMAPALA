<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('email')
                    ->label('Email ')
                    ->email()
                    ->required(),
                // DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('role')
                    ->options(['admin' => 'Admin', 'penyewa' => 'Penyewa'])
                    ->default('anggota')
                    ->required(),
                TextInput::make('no_hp')
                    ->label('Nomer Telefon')
                    ->default(null),
                Textarea::make('alamat')
                    ->label('Alamat')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Anggotas\Schemas;

use App\Models\Anggota;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

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
                    ->rules([
                        fn(?Model $record) => Rule::unique('users', 'email')
                            ->ignore($record?->user_id),
                    ])
                    ->validationMessages([
                        'unique' => 'Email sudah digunakan.',
                    ])
                    ->required(),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn(?string $state): bool => filled($state)),

                TextInput::make('nim')
                    ->numeric()
                    ->minLength(8)
                    ->rules([
                        fn(?Model $record) => Rule::unique((new Anggota())->getTable(), 'nim')
                            ->ignore($record?->id),
                    ])
                    ->validationMessages([
                        'unique' => 'NIM sudah digunakan.',
                    ])
                    ->required(),

                DateTimePicker::make('created_at')
                    ->required()
                    ->visible(fn(string $operation): bool => $operation === 'create')
                    ->default(now())
                    ->label('Didaftarkan Pada')

                // Select::make('status_keanggotaan')
                //     ->options(['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'])
                //     ->default('aktif')
                //     ->required(),
            ]);
    }
}

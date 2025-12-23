<?php

namespace App\Filament\Resources\KasPembayarans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;

class KasPembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Anggota')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) =>
                            $query->where('role', 'anggota')
                    )
                    ->required(),
                Select::make('kas_bulanan_id')
                    ->label('Bulan Ke')
                    ->relationship('kasBulanan', 'bulan')
                    ->required(),
                TextInput::make('nominal')
                    ->required()
                    ->numeric(),
                Select::make('metode')
                    ->options(['dana' => 'Online', 'cash' => 'Cash'])
                    ->default('dana')
                    ->required(),
                Select::make('status')
                    ->options(['menunggu' => 'Menunggu', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'])
                    ->default('menunggu')
                    ->required(),
                DatePicker::make('tanggal_bayar')
                    ->required(),
                Textarea::make('keterangan')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('bukti_bayar')
                    ->image()
                    ->imageEditor()
                    ->default(null),
            ]);
    }
}

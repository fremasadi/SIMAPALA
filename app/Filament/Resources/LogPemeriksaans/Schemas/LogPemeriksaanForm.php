<?php

namespace App\Filament\Resources\LogPemeriksaans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LogPemeriksaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('detail_transaksi_id')
                    ->required()
                    ->numeric(),
                TextInput::make('alat_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Select::make('kondisi_sebelum')
                    ->options([
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak ringan',
            'rusak_berat' => 'Rusak berat',
            'hilang' => 'Hilang',
        ])
                    ->required(),
                Select::make('kondisi_sesudah')
                    ->options([
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak ringan',
            'rusak_berat' => 'Rusak berat',
            'hilang' => 'Hilang',
        ])
                    ->required(),
                Textarea::make('catatan')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('tindakan')
                    ->options([
            'tidak_ada' => 'Tidak ada',
            'maintenance' => 'Maintenance',
            'perbaikan' => 'Perbaikan',
            'penggantian' => 'Penggantian',
            'penghapusan' => 'Penghapusan',
        ])
                    ->default('tidak_ada')
                    ->required(),
                DateTimePicker::make('tanggal_pemeriksaan')
                    ->required(),
            ]);
    }
}

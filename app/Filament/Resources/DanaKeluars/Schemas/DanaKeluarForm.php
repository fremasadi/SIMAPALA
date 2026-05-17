<?php

namespace App\Filament\Resources\DanaKeluars\Schemas;

use App\Models\DanaKeluar;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DanaKeluarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('jenis')
                ->options(DanaKeluar::JENIS)
                ->required(),
            TextInput::make('nominal')
                ->numeric()
                ->required(),
            DatePicker::make('tanggal')
                ->default(now())
                ->required(),
            Textarea::make('keterangan')
                ->columnSpanFull(),
            FileUpload::make('bukti_pengeluaran')
                ->label('Bukti Pengeluaran')
                ->disk('public')
                ->visibility('public')
                ->directory('pengeluaran')
                ->image()
                ->imageEditor(),
        ]);
    }
}

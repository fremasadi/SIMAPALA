<?php

namespace App\Filament\Resources\TransaksiAlats\RelationManagers;

use App\Models\Alat;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DetailTransaksiRelationManager extends RelationManager
{
    protected static string $relationship = 'detailTransaksis';

    protected static ?string $title = 'Detail Alat';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('alat_id')
                ->label('Alat')
                ->options(fn () => Alat::orderBy('nama_alat')->pluck('nama_alat', 'id'))
                ->searchable()
                ->required(),

            Select::make('kondisi_kembali')
                ->label('Kondisi Kembali')
                ->options([
                    'baik'  => 'Baik',
                    'rusak' => 'Rusak',
                    'hilang' => 'Hilang',
                ])
                ->nullable(),

            TextInput::make('denda_telat')
                ->label('Denda Telat (Rp)')
                ->numeric()
                ->default(0)
                ->prefix('Rp'),

            TextInput::make('denda_rusak')
                ->label('Denda Rusak (Rp)')
                ->numeric()
                ->default(0)
                ->prefix('Rp'),

            TextInput::make('keterangan')
                ->label('Keterangan')
                ->nullable(),

            FileUpload::make('foto_kembali')
                ->label('Foto Kembali')
                ->image()
                ->disk('public')
                ->directory('foto-kembali')
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('transaksi'))
            ->columns([
                TextColumn::make('alat.nama_alat')
                    ->label('Alat')
                    ->searchable(),

                TextColumn::make('transaksi.jenis_jaminan')
                    ->label('Jenis Jaminan')
                    ->placeholder('-')
                    ->searchable(),

                ImageColumn::make('transaksi.foto_jaminan')
                    ->label('Foto Jaminan')
                    ->disk('public')
                    ->height(60)
                    ->width(60)
                    ->square(),

                TextColumn::make('kondisi_kembali')
                    ->label('Kondisi')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'baik'   => 'success',
                        'rusak'  => 'warning',
                        'hilang' => 'danger',
                        default  => 'gray',
                    }),

                TextColumn::make('denda_telat')
                    ->label('Denda Telat')
                    ->money('IDR')
                    ->default(0),

                TextColumn::make('denda_rusak')
                    ->label('Denda Rusak')
                    ->money('IDR')
                    ->default(0),

                TextColumn::make('total_denda')
                    ->label('Total Denda')
                    ->money('IDR')
                    ->getStateUsing(fn ($record) => $record->total_denda),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30),

                ImageColumn::make('foto_kembali')
                    ->label('Foto')
                    ->disk('public')
                    ->height(60)
                    ->width(60)
                    ->square(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Alats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;

class AlatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular(),
                TextColumn::make('kode_alat')
                    ->label('Kode Alat')
                    ->searchable(),
                TextColumn::make('nama_alat')
                    ->label('Nama Alat')
                    ->searchable(),
                TextColumn::make('ukuran')
                    ->label('Ukuran')
                    ->searchable(),
                TextColumn::make('bahan')
                    ->label('Bahan')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('harga_sewa')
                    ->label('Harga Sewa')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
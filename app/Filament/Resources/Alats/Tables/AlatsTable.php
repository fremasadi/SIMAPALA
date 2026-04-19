<?php

namespace App\Filament\Resources\Alats\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                    ->badge()
                    ->separator(',')
                    ->getStateUsing(fn($record) => is_array($record->bahan) ? $record->bahan : []),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'tersedia' => 'success',
                        'dipinjam' => 'warning',
                        'rusak'    => 'danger',
                        'hilang'   => 'gray',
                        default    => 'gray',
                    }),
                TextColumn::make('harga_alat')
                    ->label('Harga Alat')
                    ->numeric()
                    ->sortable(),
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

                DeleteAction::make(),
            ]);
    }
}

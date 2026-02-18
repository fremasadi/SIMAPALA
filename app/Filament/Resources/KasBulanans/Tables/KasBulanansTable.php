<?php

namespace App\Filament\Resources\KasBulanans\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KasBulanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable(),
                TextColumn::make('bulan')
                    ->label('Bulan ke')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tahun')
                    ->label('Tahun ke')
                    ->sortable(),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
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

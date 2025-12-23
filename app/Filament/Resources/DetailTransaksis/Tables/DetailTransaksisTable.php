<?php

namespace App\Filament\Resources\DetailTransaksis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;

class DetailTransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
                    ->defaultSort('id', 'desc')

            ->columns([
                TextColumn::make('transaksi.user.name')
                    ->label('Nama Penyewa')
                    ->searchable(),
                TextColumn::make('alat.nama_alat')
                    ->searchable(),
                TextColumn::make('kondisi_kembali')
                    ->searchable(),
                TextColumn::make('denda'),
                TextColumn::make('keterangan'),
                ImageColumn::make('foto_kembali')
                    ->label('Foto Kembali')
                    ->disk('public') // sesuai storage
                    ->height(80)
                    ->width(80)
                    ->square()
                    ->visibility('public'),
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

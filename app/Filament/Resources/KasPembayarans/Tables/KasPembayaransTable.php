<?php

namespace App\Filament\Resources\KasPembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KasPembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kasBulanan.bulan')
                    ->label('Kas Pada Bulan')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable(),
                TextColumn::make('nominal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('metode')
                    ->badge(),
                TextColumn::make('bukti_bayar')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('tanggal_bayar')
                    ->date()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}

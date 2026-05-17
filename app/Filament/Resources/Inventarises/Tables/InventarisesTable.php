<?php

namespace App\Filament\Resources\Inventarises\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventarisesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_inventaris')->label('Kode')->searchable(),
                TextColumn::make('nama_barang')->label('Nama Barang')->searchable(),
                TextColumn::make('kategori')->searchable(),
                TextColumn::make('jumlah')->sortable(),
                TextColumn::make('kondisi')->badge(),
                TextColumn::make('tanggal_perolehan')->date('d M Y')->sortable(),
                TextColumn::make('harga_perolehan')->money('IDR')->sortable(),
                TextColumn::make('sumber_dana')->label('Sumber Dana')->toggleable(),
            ])
            ->defaultSort('tanggal_perolehan', 'desc')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}

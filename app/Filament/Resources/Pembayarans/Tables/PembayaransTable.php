<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                // TextColumn::make('transaksi.id')
                //     ->searchable(),
                TextColumn::make('order_id')
                    ->searchable(),
                // TextColumn::make('transaction_id')
                //     ->searchable(),
                TextColumn::make('gross_amount')
                    ->label('Total harga')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_type')
                    ->label('Metode Pembayaran')
                    ->badge(),
                TextColumn::make('bank')
                    ->label('Nama Bank')
                    ->searchable(),
                TextColumn::make('va_number')
                    ->label('Va Number')
                    ->searchable(),
                TextColumn::make('transaction_status')
                    ->label('Status Transaksi')
                    ->badge(),
                TextColumn::make('transaction_time')
                    ->label('Waktu Transaksi')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('settlement_time')
                    ->label('Waktu Dibayar')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    // ->toggleable(isToggledHiddenByDefault: true),
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

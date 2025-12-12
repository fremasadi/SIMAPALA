<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_type')
                    ->badge(),
                TextColumn::make('bank')
                    ->searchable(),
                TextColumn::make('va_number')
                    ->searchable(),
                TextColumn::make('transaction_status')
                    ->badge(),
                TextColumn::make('transaction_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('settlement_time')
                    ->dateTime()
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
                // EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}

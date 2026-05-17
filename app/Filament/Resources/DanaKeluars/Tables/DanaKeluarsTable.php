<?php

namespace App\Filament\Resources\DanaKeluars\Tables;

use App\Models\DanaKeluar;
use App\Models\Inventaris;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DanaKeluarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis')
                    ->badge()
                    ->formatStateUsing(fn ($state) => DanaKeluar::JENIS[$state] ?? ucfirst($state)),
                TextColumn::make('nominal')->money('IDR')->sortable(),
                TextColumn::make('tanggal')->date('d M Y')->sortable(),
                TextColumn::make('keterangan')->limit(50)->searchable(),
                TextColumn::make('sumber_type')
                    ->label('Sumber')
                    ->formatStateUsing(fn ($state) => $state ? class_basename($state) : '-'),
                ImageColumn::make('bukti_pengeluaran')
                    ->label('Bukti')
                    ->disk('public')
                    ->height(50)
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('jenis')->options(DanaKeluar::JENIS),
            ])
            ->defaultSort('tanggal', 'desc')
            ->recordActions([
                EditAction::make()
                    ->visible(fn (DanaKeluar $record) => $record->sumber_type !== Inventaris::class),
                DeleteAction::make()
                    ->visible(fn (DanaKeluar $record) => $record->sumber_type !== Inventaris::class),
            ]);
    }
}

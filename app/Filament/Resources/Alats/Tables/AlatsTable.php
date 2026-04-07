<?php

namespace App\Filament\Resources\Alats\Tables;

use App\Models\Alat;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
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
                    ->badge()
                    ->separator(',')
                    ->getStateUsing(fn ($record) => is_array($record->bahan) ? $record->bahan : []),
                TextColumn::make('status')
                    ->badge(),
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
                Action::make('duplikasi')
                    ->label('Duplikasi')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('info')
                    ->modalHeading('Duplikasi Data Alat')
                    ->form([
                        TextInput::make('kode_alat_prefix')
                            ->label('Kode Alat')
                            ->helperText('Jika jumlah > 1, kode otomatis ditambah suffix -1, -2, dst.')
                            ->required()
                            ->default(fn ($record) => $record->kode_alat . '-copy'),
                        TextInput::make('jumlah')
                            ->label('Jumlah Duplikasi')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(20)
                            ->default(1)
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $jumlah = (int) $data['jumlah'];
                        $prefix = $data['kode_alat_prefix'];

                        for ($i = 1; $i <= $jumlah; $i++) {
                            $kode = $jumlah === 1 ? $prefix : "{$prefix}-{$i}";

                            $record->replicate()
                                ->fill(['kode_alat' => $kode])
                                ->save();
                        }
                    }),
                DeleteAction::make(),
            ]);
    }
}
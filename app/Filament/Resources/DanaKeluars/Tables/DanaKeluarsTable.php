<?php

namespace App\Filament\Resources\DanaKeluars\Tables;

use App\Exports\DanaKeluarExport;
use App\Models\DanaKeluar;
use App\Models\Inventaris;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

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
                Filter::make('tanggal')
                    ->label('Rentang Tanggal')
                    ->form([
                        DatePicker::make('dari')
                            ->label('Dari Tanggal'),
                        DatePicker::make('sampai')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['dari'], fn ($q) => $q->whereDate('tanggal', '>=', $data['dari']))
                            ->when($data['sampai'], fn ($q) => $q->whereDate('tanggal', '<=', $data['sampai']));
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];
                        if ($data['dari'] ?? null) {
                            $indicators[] = 'Dari: '.$data['dari'];
                        }
                        if ($data['sampai'] ?? null) {
                            $indicators[] = 'Sampai: '.$data['sampai'];
                        }

                        return $indicators;
                    }),
            ])
            ->defaultSort('tanggal', 'desc')
            ->recordActions([
                EditAction::make()
                    ->visible(fn (DanaKeluar $record) => $record->sumber_type !== Inventaris::class),
                DeleteAction::make()
                    ->visible(fn (DanaKeluar $record) => $record->sumber_type !== Inventaris::class),
            ])
            ->toolbarActions([
                Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($livewire) {
                        return Excel::download(
                            new DanaKeluarExport($livewire->tableFilters ?? []),
                            'dana-keluar-'.now()->format('Y-m-d').'.xlsx'
                        );
                    }),
            ]);
    }
}

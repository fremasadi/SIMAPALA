<?php

namespace App\Filament\Resources\DanaMasuks\Tables;

use App\Exports\DanaMasukExport;
use App\Models\DanaMasuk;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class DanaMasuksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis')
                    ->badge()
                    ->formatStateUsing(fn ($state) => DanaMasuk::JENIS[$state] ?? ucfirst($state)),
                TextColumn::make('nominal')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('keterangan')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('tanggal')
                    ->date('d M Y')
                    ->sortable(),
                // TextColumn::make('status')
                //     ->badge()
                //     ->formatStateUsing(fn ($state) => match ($state) {
                //         'approved' => 'Diterima',
                //         'pending'  => 'Menunggu',
                //         default    => ucfirst($state),
                //     })
                //     ->color(fn ($state) => match ($state) {
                //         'approved' => 'success',
                //         'pending'  => 'warning',
                //         default    => 'gray',
                //     }),
                TextColumn::make('user.name')
                    ->label('Diinput Oleh')
                    ->searchable(),
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
                SelectFilter::make('jenis')
                    ->label('Jenis Dana')
                    ->options(DanaMasuk::JENIS)
                    ->placeholder('Semua Jenis'),

                // SelectFilter::make('status')
                //     ->label('Status')
                //     ->options([
                //         // 'pending'  => 'Menunggu',
                //         'approved' => 'Diterima',
                //     ])
                //     ->placeholder('Semua Status'),

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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($livewire) {
                        return Excel::download(
                            new DanaMasukExport($livewire->tableFilters ?? []),
                            'dana-masuk-'.now()->format('Y-m-d').'.xlsx'
                        );
                    }),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

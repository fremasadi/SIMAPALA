<?php

namespace App\Filament\Resources\DanaMasuks\Tables;

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
use Rap2hpoutre\FastExcel\FastExcel;

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
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'approved' => 'success',
                        'pending'  => 'warning',
                        default    => 'gray',
                    }),
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

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                    ])
                    ->placeholder('Semua Status'),

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
                            $indicators[] = 'Dari: ' . $data['dari'];
                        }
                        if ($data['sampai'] ?? null) {
                            $indicators[] = 'Sampai: ' . $data['sampai'];
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
                        $filters = $livewire->tableFilters ?? [];

                        $data = DanaMasuk::query()
                            ->with('user')
                            ->when($filters['jenis']['value'] ?? null, fn ($q, $v) => $q->where('jenis', $v))
                            ->when($filters['status']['value'] ?? null, fn ($q, $v) => $q->where('status', $v))
                            ->when($filters['tanggal']['dari'] ?? null, fn ($q, $v) => $q->whereDate('tanggal', '>=', $v))
                            ->when($filters['tanggal']['sampai'] ?? null, fn ($q, $v) => $q->whereDate('tanggal', '<=', $v))
                            ->orderBy('tanggal', 'desc')
                            ->get()
                            ->map(fn ($row, $i) => [
                                'No'            => $i + 1,
                                'Jenis'         => DanaMasuk::JENIS[$row->jenis] ?? ucfirst($row->jenis),
                                'Nominal (Rp)'  => $row->nominal,
                                'Keterangan'    => $row->keterangan,
                                'Tanggal'       => $row->tanggal?->format('d/m/Y'),
                                'Status'        => ucfirst($row->status),
                                'Diinput Oleh'  => $row->user?->name,
                            ]);

                        return (new FastExcel($data))->download('dana-masuk-' . now()->format('Y-m-d') . '.xlsx');
                    }),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

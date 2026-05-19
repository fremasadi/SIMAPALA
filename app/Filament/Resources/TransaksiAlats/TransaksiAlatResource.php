<?php

namespace App\Filament\Resources\TransaksiAlats;

use App\Filament\Resources\TransaksiAlats\Pages\EditTransaksiAlat;
use App\Filament\Resources\TransaksiAlats\Pages\ListTransaksiAlats;
use App\Filament\Resources\TransaksiAlats\Pages\ViewTransaksiAlat;
use App\Filament\Resources\TransaksiAlats\RelationManagers\DetailTransaksiRelationManager;
use App\Filament\Resources\TransaksiAlats\Schemas\TransaksiAlatForm;
use App\Filament\Resources\TransaksiAlats\Tables\TransaksiAlatsTable;
use App\Models\TransaksiAlat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class TransaksiAlatResource extends Resource
{
    protected static ?string $model = TransaksiAlat::class;

    protected static ?string $modelLabel = 'Transaksi Peminjaman';

    protected static ?string $pluralModelLabel = 'Transaksi Peminjaman';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard';

    protected static UnitEnum|string|null $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Transaksi Peminjaman';

    public static function form(Schema $schema): Schema
    {
        return TransaksiAlatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaksiAlatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DetailTransaksiRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('detailTransaksis')
            ->whereHas('pembayaran', fn ($q) => $q->whereIn('transaction_status', ['settlement', 'capture']));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransaksiAlats::route('/'),
            'view' => ViewTransaksiAlat::route('/{record}'),
            'edit' => EditTransaksiAlat::route('/{record}/edit'),
        ];
    }
}

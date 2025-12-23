<?php

namespace App\Filament\Resources\TransaksiAlats;

use App\Filament\Resources\TransaksiAlats\Pages\CreateTransaksiAlat;
use App\Filament\Resources\TransaksiAlats\Pages\EditTransaksiAlat;
use App\Filament\Resources\TransaksiAlats\Pages\ListTransaksiAlats;
use App\Filament\Resources\TransaksiAlats\Schemas\TransaksiAlatForm;
use App\Filament\Resources\TransaksiAlats\Tables\TransaksiAlatsTable;
use App\Models\TransaksiAlat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TransaksiAlatResource extends Resource
{
    protected static ?string $model = TransaksiAlat::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard';
    protected static UnitEnum|string|null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Daftar Transaksi Alat';

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransaksiAlats::route('/'),
            // 'create' => CreateTransaksiAlat::route('/create'),
            'edit' => EditTransaksiAlat::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\KasPembayarans;

use App\Filament\Resources\KasPembayarans\Pages\CreateKasPembayaran;
use App\Filament\Resources\KasPembayarans\Pages\EditKasPembayaran;
use App\Filament\Resources\KasPembayarans\Pages\ListKasPembayarans;
use App\Filament\Resources\KasPembayarans\Schemas\KasPembayaranForm;
use App\Filament\Resources\KasPembayarans\Tables\KasPembayaransTable;
use App\Models\KasPembayaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;


class KasPembayaranResource extends Resource
{
    protected static ?string $model = KasPembayaran::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Pembayaran Kas';

    public static function form(Schema $schema): Schema
    {
        return KasPembayaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KasPembayaransTable::configure($table);
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
            'index' => ListKasPembayarans::route('/'),
            'create' => CreateKasPembayaran::route('/create'),
            'edit' => EditKasPembayaran::route('/{record}/edit'),
        ];
    }
}

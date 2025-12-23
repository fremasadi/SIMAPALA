<?php

namespace App\Filament\Resources\DetailTransaksis;

use App\Filament\Resources\DetailTransaksis\Pages\CreateDetailTransaksi;
use App\Filament\Resources\DetailTransaksis\Pages\EditDetailTransaksi;
use App\Filament\Resources\DetailTransaksis\Pages\ListDetailTransaksis;
use App\Filament\Resources\DetailTransaksis\Schemas\DetailTransaksiForm;
use App\Filament\Resources\DetailTransaksis\Tables\DetailTransaksisTable;
use App\Models\DetailTransaksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DetailTransaksiResource extends Resource
{
    protected static ?string $model = DetailTransaksi::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static UnitEnum|string|null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Detail Transaksi Alat';

    public static function form(Schema $schema): Schema
    {
        return DetailTransaksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DetailTransaksisTable::configure($table);
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
            'index' => ListDetailTransaksis::route('/'),
            'create' => CreateDetailTransaksi::route('/create'),
            'edit' => EditDetailTransaksi::route('/{record}/edit'),
        ];
    }
}

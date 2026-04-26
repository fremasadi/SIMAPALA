<?php

namespace App\Filament\Resources\DanaMasuks;

use App\Filament\Resources\DanaMasuks\Pages\CreateDanaMasuk;
use App\Filament\Resources\DanaMasuks\Pages\EditDanaMasuk;
use App\Filament\Resources\DanaMasuks\Pages\ListDanaMasuks;
use App\Filament\Resources\DanaMasuks\Schemas\DanaMasukForm;
use App\Filament\Resources\DanaMasuks\Tables\DanaMasuksTable;
use App\Models\DanaMasuk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;


class DanaMasukResource extends Resource
{
    protected static ?string $model = DanaMasuk::class;
    protected static ?string $modelLabel = 'Dana Masuk';
    protected static ?string $pluralModelLabel = 'Dana Masuk';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wallet';
    protected static UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Dana Masuk';

    public static function form(Schema $schema): Schema
    {
        return DanaMasukForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DanaMasuksTable::configure($table);
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
            'index' => ListDanaMasuks::route('/'),
            'create' => CreateDanaMasuk::route('/create'),
            'edit' => EditDanaMasuk::route('/{record}/edit'),
        ];
    }
}

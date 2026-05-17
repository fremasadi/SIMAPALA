<?php

namespace App\Filament\Resources\DanaKeluars;

use App\Filament\Resources\DanaKeluars\Pages\CreateDanaKeluar;
use App\Filament\Resources\DanaKeluars\Pages\EditDanaKeluar;
use App\Filament\Resources\DanaKeluars\Pages\ListDanaKeluars;
use App\Filament\Resources\DanaKeluars\Schemas\DanaKeluarForm;
use App\Filament\Resources\DanaKeluars\Tables\DanaKeluarsTable;
use App\Models\DanaKeluar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DanaKeluarResource extends Resource
{
    protected static ?string $model = DanaKeluar::class;
    protected static ?string $modelLabel = 'Dana Keluar';
    protected static ?string $pluralModelLabel = 'Dana Keluar';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-trending-down';
    protected static UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Dana Keluar';

    public static function form(Schema $schema): Schema
    {
        return DanaKeluarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DanaKeluarsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDanaKeluars::route('/'),
            'create' => CreateDanaKeluar::route('/create'),
            'edit' => EditDanaKeluar::route('/{record}/edit'),
        ];
    }
}

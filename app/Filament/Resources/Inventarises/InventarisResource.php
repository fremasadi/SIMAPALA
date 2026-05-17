<?php

namespace App\Filament\Resources\Inventarises;

use App\Filament\Resources\Inventarises\Pages\CreateInventaris;
use App\Filament\Resources\Inventarises\Pages\EditInventaris;
use App\Filament\Resources\Inventarises\Pages\ListInventarises;
use App\Filament\Resources\Inventarises\Schemas\InventarisForm;
use App\Filament\Resources\Inventarises\Tables\InventarisesTable;
use App\Models\Inventaris;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class InventarisResource extends Resource
{
    protected static ?string $model = Inventaris::class;
    protected static ?string $modelLabel = 'Inventaris';
    protected static ?string $pluralModelLabel = 'Inventaris';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Inventaris';

    public static function form(Schema $schema): Schema
    {
        return InventarisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventarisesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventarises::route('/'),
            'create' => CreateInventaris::route('/create'),
            'edit' => EditInventaris::route('/{record}/edit'),
        ];
    }
}

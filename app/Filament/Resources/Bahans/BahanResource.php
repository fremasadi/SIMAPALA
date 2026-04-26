<?php

namespace App\Filament\Resources\Bahans;

use App\Filament\Resources\Bahans\Pages\CreateBahan;
use App\Filament\Resources\Bahans\Pages\EditBahan;
use App\Filament\Resources\Bahans\Pages\ListBahans;
use App\Filament\Resources\Bahans\Schemas\BahanForm;
use App\Filament\Resources\Bahans\Tables\BahansTable;
use App\Models\Bahan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BahanResource extends Resource
{
    protected static ?string $model = Bahan::class;
    protected static ?string $modelLabel = 'Bahan';
    protected static ?string $pluralModelLabel = 'Bahan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Bahan';

    public static function form(Schema $schema): Schema
    {
        return BahanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BahansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBahans::route('/'),
            'create' => CreateBahan::route('/create'),
            'edit'   => EditBahan::route('/{record}/edit'),
        ];
    }
}

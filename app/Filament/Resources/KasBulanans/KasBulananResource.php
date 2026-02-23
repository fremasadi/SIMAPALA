<?php

namespace App\Filament\Resources\KasBulanans;

use App\Filament\Resources\KasBulanans\Pages\CreateKasBulanan;
use App\Filament\Resources\KasBulanans\Pages\EditKasBulanan;
use App\Filament\Resources\KasBulanans\Pages\ListKasBulanans;
use App\Filament\Resources\KasBulanans\Schemas\KasBulananForm;
use App\Filament\Resources\KasBulanans\Tables\KasBulanansTable;
use App\Models\KasBulanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KasBulananResource extends Resource
{
    protected static ?string $model = KasBulanan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-date-range';
    protected static UnitEnum|string|null $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Daftar Kas';

    public static function form(Schema $schema): Schema
    {
        return KasBulananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KasBulanansTable::configure($table);
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
            'index' => ListKasBulanans::route('/'),
            'create' => CreateKasBulanan::route('/create'),
            'edit' => EditKasBulanan::route('/{record}/edit'),
        ];
    }
}

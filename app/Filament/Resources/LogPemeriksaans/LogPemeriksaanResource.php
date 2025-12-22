<?php

namespace App\Filament\Resources\LogPemeriksaans;

use App\Filament\Resources\LogPemeriksaans\Pages\CreateLogPemeriksaan;
use App\Filament\Resources\LogPemeriksaans\Pages\EditLogPemeriksaan;
use App\Filament\Resources\LogPemeriksaans\Pages\ListLogPemeriksaans;
use App\Filament\Resources\LogPemeriksaans\Schemas\LogPemeriksaanForm;
use App\Filament\Resources\LogPemeriksaans\Tables\LogPemeriksaansTable;
use App\Models\LogPemeriksaan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LogPemeriksaanResource extends Resource
{
    protected static ?string $model = LogPemeriksaan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LogPemeriksaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LogPemeriksaansTable::configure($table);
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
            'index' => ListLogPemeriksaans::route('/'),
            'create' => CreateLogPemeriksaan::route('/create'),
            'edit' => EditLogPemeriksaan::route('/{record}/edit'),
        ];
    }
}

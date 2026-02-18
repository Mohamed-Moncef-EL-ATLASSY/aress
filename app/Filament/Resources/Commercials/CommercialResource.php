<?php

namespace App\Filament\Resources\Commercials;

use App\Filament\Resources\Commercials\Pages\CreateCommercial;
use App\Filament\Resources\Commercials\Pages\EditCommercial;
use App\Filament\Resources\Commercials\Pages\ListCommercials;
use App\Filament\Resources\Commercials\Schemas\CommercialForm;
use App\Filament\Resources\Commercials\Tables\CommercialsTable;
use App\Models\Commercial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CommercialResource extends Resource
{
    protected static ?string $model = Commercial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CommercialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommercialsTable::configure($table);
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
            'index' => ListCommercials::route('/'),
            'create' => CreateCommercial::route('/create'),
            'edit' => EditCommercial::route('/{record}/edit'),
        ];
    }
}

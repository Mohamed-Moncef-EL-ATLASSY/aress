<?php

namespace App\Filament\Resources\CommercialAvailabilities;

use App\Filament\Resources\CommercialAvailabilities\Pages\CreateCommercialAvailability;
use App\Filament\Resources\CommercialAvailabilities\Pages\EditCommercialAvailability;
use App\Filament\Resources\CommercialAvailabilities\Pages\CommercialAvailabilityCalendar;
use App\Filament\Resources\CommercialAvailabilities\Pages\ListCommercialAvailabilities;
use App\Filament\Resources\CommercialAvailabilities\Schemas\CommercialAvailabilityForm;
use App\Filament\Resources\CommercialAvailabilities\Tables\CommercialAvailabilitiesTable;
use App\Models\CommercialAvailability;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CommercialAvailabilityResource extends Resource
{
    protected static ?string $model = CommercialAvailability::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return CommercialAvailabilityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommercialAvailabilitiesTable::configure($table);
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
            'index' => ListCommercialAvailabilities::route('/'),
            'calendar' => CommercialAvailabilityCalendar::route('/calendar'),
            'create' => CreateCommercialAvailability::route('/create'),
            'edit' => EditCommercialAvailability::route('/{record}/edit'),
        ];
    }
}

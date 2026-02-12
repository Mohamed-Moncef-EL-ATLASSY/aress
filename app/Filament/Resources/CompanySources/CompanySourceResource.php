<?php

namespace App\Filament\Resources\CompanySources;

use App\Filament\Resources\CompanySources\Pages\CreateCompanySource;
use App\Filament\Resources\CompanySources\Pages\EditCompanySource;
use App\Filament\Resources\CompanySources\Pages\ListCompanySources;
use App\Filament\Resources\CompanySources\Schemas\CompanySourceForm;
use App\Filament\Resources\CompanySources\Tables\CompanySourcesTable;
use App\Models\CompanySource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CompanySourceResource extends Resource
{
    protected static ?string $model = CompanySource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CompanySourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompanySourcesTable::configure($table);
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
            'index' => ListCompanySources::route('/'),
            'create' => CreateCompanySource::route('/create'),
            'edit' => EditCompanySource::route('/{record}/edit'),
        ];
    }
}

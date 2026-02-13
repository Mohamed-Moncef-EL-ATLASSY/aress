<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadsKanbanResource\Pages\ManageLeadsKanban;
use BackedEnum;
use Filament\Resources\Resource;

class LeadsKanbanResource extends Resource
{
    protected static ?string $navigationLabel = 'Kanban';

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-view-columns';

    protected static \UnitEnum|string|null $navigationGroup = 'Leads';

    protected static ?int $navigationSort = 2;

    public static function getPages(): array
    {
        return [
            'index' => ManageLeadsKanban::route('/'),
        ];
    }
}

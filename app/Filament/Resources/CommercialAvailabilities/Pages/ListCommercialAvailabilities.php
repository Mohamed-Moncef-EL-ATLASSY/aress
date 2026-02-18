<?php

namespace App\Filament\Resources\CommercialAvailabilities\Pages;

use App\Filament\Resources\CommercialAvailabilities\CommercialAvailabilityResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListCommercialAvailabilities extends ListRecords
{
    protected static string $resource = CommercialAvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('calendar')
                ->label('Calendar')
                ->icon(Heroicon::OutlinedCalendarDays)
                ->url(CommercialAvailabilityResource::getUrl('calendar')),
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Commercials\Pages;

use App\Filament\Resources\Commercials\CommercialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommercials extends ListRecords
{
    protected static string $resource = CommercialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

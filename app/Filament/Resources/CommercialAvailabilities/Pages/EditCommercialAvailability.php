<?php

namespace App\Filament\Resources\CommercialAvailabilities\Pages;

use App\Filament\Resources\CommercialAvailabilities\CommercialAvailabilityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommercialAvailability extends EditRecord
{
    protected static string $resource = CommercialAvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Commercials\Pages;

use App\Filament\Resources\Commercials\CommercialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommercial extends EditRecord
{
    protected static string $resource = CommercialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

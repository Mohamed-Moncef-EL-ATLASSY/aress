<?php

namespace App\Filament\Resources\CompanySources\Pages;

use App\Filament\Resources\CompanySources\CompanySourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompanySource extends EditRecord
{
    protected static string $resource = CompanySourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

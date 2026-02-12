<?php

namespace App\Filament\Resources\CompanySources\Pages;

use App\Filament\Resources\CompanySources\CompanySourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanySources extends ListRecords
{
    protected static string $resource = CompanySourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\CommercialAvailabilities\Pages;

use App\Filament\Resources\CommercialAvailabilities\CommercialAvailabilityResource;
use Filament\Resources\Pages\Page;

class CommercialAvailabilityCalendar extends Page
{
    protected static string $resource = CommercialAvailabilityResource::class;

    protected string $view = 'filament.resources.commercial-availabilities.pages.commercial-availability-calendar';

    protected static ?string $title = 'Calendar';
}

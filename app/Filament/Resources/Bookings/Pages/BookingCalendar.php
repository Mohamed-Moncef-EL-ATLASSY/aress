<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\Page;

class BookingCalendar extends Page
{
    protected static string $resource = BookingResource::class;

    protected string $view = 'filament.resources.bookings.pages.booking-calendar';

    protected static ?string $title = 'Calendar';
}

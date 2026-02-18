<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('commercial_id')
                    ->label('Commercial')
                    ->relationship('commercial', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('user_id')
                    ->label('Client')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('status')
                    ->required()
                    ->options(array_combine(Booking::STATUSES, Booking::STATUSES))
                    ->default(Booking::STATUS_REQUESTED),
                DateTimePicker::make('start_at')
                    ->label('Start')
                    ->required(),
                DateTimePicker::make('end_at')
                    ->label('End')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(3)
                    ->maxLength(2000),
            ]);
    }
}

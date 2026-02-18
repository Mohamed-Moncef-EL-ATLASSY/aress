<?php

namespace App\Filament\Resources\CommercialAvailabilities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class CommercialAvailabilityForm
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
                Select::make('day_of_week')
                    ->label('Day')
                    ->options([
                        0 => 'Sunday',
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                    ])
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Start')
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label('End')
                    ->seconds(false)
                    ->required(),
            ]);
    }
}

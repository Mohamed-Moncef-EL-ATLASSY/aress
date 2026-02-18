<?php

namespace App\Filament\Resources\Ratings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RatingForm
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
                Select::make('booking_id')
                    ->label('Booking')
                    ->relationship('booking', 'id')
                    ->searchable()
                    ->preload(),
                Select::make('user_id')
                    ->label('Client')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('stars')
                    ->label('Stars')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                    ])
                    ->required(),
                Textarea::make('comment')
                    ->columnSpanFull()
                    ->rows(3)
                    ->maxLength(2000),
            ]);
    }
}

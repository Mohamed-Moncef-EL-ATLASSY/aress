<?php

namespace App\Filament\Resources\Commercials\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommercialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->required()
                    ->maxLength(50),
                TextInput::make('headline')
                    ->maxLength(255),
                Textarea::make('bio')
                    ->columnSpanFull()
                    ->rows(4)
                    ->maxLength(2000),
                TextInput::make('hourly_rate')
                    ->label('Hourly Rate')
                    ->numeric()
                    ->minValue(0),
                Toggle::make('active')
                    ->default(true),
            ]);
    }
}

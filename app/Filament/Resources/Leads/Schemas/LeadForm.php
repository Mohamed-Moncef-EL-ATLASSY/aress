<?php

namespace App\Filament\Resources\Leads\Schemas;

use App\Models\Lead;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LeadForm
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
                    ->tel()
                    ->required()
                    ->maxLength(50),
                Select::make('company_source_id')
                    ->label('Company Source')
                    ->required()
                    ->relationship('companySource', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('status')
                    ->required()
                    ->options(array_combine(Lead::STATUSES, Lead::STATUSES))
                    ->default(Lead::STATUS_NEW),
                Textarea::make('notes')
                    ->columnSpanFull()
                    ->maxLength(2000),
            ]);
    }
}

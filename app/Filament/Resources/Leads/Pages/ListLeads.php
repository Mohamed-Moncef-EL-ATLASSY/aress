<?php

namespace App\Filament\Resources\Leads\Pages;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'new' => Tab::make('New')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Lead::STATUS_NEW))
                ->badge(Lead::query()->where('status', Lead::STATUS_NEW)->count()),
            'contacted' => Tab::make('Contacted')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Lead::STATUS_CONTACTED))
                ->badge(Lead::query()->where('status', Lead::STATUS_CONTACTED)->count()),
            'interested' => Tab::make('Interested')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Lead::STATUS_INTERESTED))
                ->badge(Lead::query()->where('status', Lead::STATUS_INTERESTED)->count()),
            'negotiation' => Tab::make('Negotiation')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Lead::STATUS_NEGOTIATION))
                ->badge(Lead::query()->where('status', Lead::STATUS_NEGOTIATION)->count()),
            'won' => Tab::make('Won')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Lead::STATUS_WON))
                ->badge(Lead::query()->where('status', Lead::STATUS_WON)->count()),
            'lost' => Tab::make('Lost')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', Lead::STATUS_LOST))
                ->badge(Lead::query()->where('status', Lead::STATUS_LOST)->count()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

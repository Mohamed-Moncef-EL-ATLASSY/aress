<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadsStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $totalLeads = Lead::query()->count();
        $wonLeads = Lead::query()->where('status', Lead::STATUS_WON)->count();
        $conversionRate = $totalLeads > 0 ? round(($wonLeads / $totalLeads) * 100, 1) : 0;

        return [
            Stat::make('Total Leads', $totalLeads)
                ->color('primary'),
            Stat::make('Conversion Rate', $conversionRate . '% Won / total')
                ->color('success'),
            Stat::make('New', Lead::query()->where('status', Lead::STATUS_NEW)->count())
                ->color('gray'),
            Stat::make('Contacted', Lead::query()->where('status', Lead::STATUS_CONTACTED)->count())
                ->color('info'),
            Stat::make('Interested', Lead::query()->where('status', Lead::STATUS_INTERESTED)->count())
                ->color('warning'),
            Stat::make('Negotiation', Lead::query()->where('status', Lead::STATUS_NEGOTIATION)->count())
                ->color('primary'),
            Stat::make('Won', $wonLeads)
                ->color('success'),
            Stat::make('Lost', Lead::query()->where('status', Lead::STATUS_LOST)->count())
                ->color('danger'),
        ];
    }
}

<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LeadsMonthlyChart;
use App\Filament\Widgets\LeadsStatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | array
    {
        return 4;
    }

    public function getWidgets(): array
    {
        return [
            LeadsStatsOverview::class,
            LeadsMonthlyChart::class,
        ];
    }
}

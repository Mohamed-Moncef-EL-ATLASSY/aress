<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class LeadsMonthlyChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Lead Evolution';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $start = Carbon::now()->startOfMonth()->subMonths(5);
        $end = Carbon::now()->endOfMonth();

        $labels = [];
        $data = [];

        $counts = Lead::query()
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy(fn (Lead $lead) => $lead->created_at->format('Y-m'))
            ->map(fn ($leads) => $leads->count());

        for ($i = 0; $i < 6; $i++) {
            $month = $start->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->format('M Y');
            $data[] = $counts[$key] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

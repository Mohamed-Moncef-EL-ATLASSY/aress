<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CommercialAvailabilities\CommercialAvailabilityResource;
use App\Models\CommercialAvailability;
use Carbon\Carbon;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CommercialAvailabilityCalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = CommercialAvailability::class;

    protected static ?string $heading = 'Availability Calendar';

    public function fetchEvents(array $fetchInfo): array
    {
        $start = Carbon::parse($fetchInfo['start'])->startOfDay();
        $end = Carbon::parse($fetchInfo['end'])->endOfDay();

        return CommercialAvailability::query()
            ->with('commercial')
            ->orderBy('commercial_id')
            ->get()
            ->map(function (CommercialAvailability $availability) use ($start, $end): array {
                return [
                    'id' => (string) $availability->id,
                    'title' => $availability->commercial?->name ?? 'Availability',
                    'daysOfWeek' => [(int) $availability->day_of_week],
                    'startTime' => $availability->start_time,
                    'endTime' => $availability->end_time,
                    'startRecur' => $start->toDateString(),
                    'endRecur' => $end->toDateString(),
                    'url' => CommercialAvailabilityResource::getUrl('edit', ['record' => $availability]),
                    'backgroundColor' => '#22c55e',
                ];
            })
            ->toArray();
    }

    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'headerToolbar' => [
                'left' => 'dayGridMonth,timeGridWeek,timeGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
            'editable' => false,
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(function (Forms\Form $form, array $arguments): void {
                    if (! isset($arguments['start'])) {
                        return;
                    }

                    $start = Carbon::parse($arguments['start']);
                    $end = isset($arguments['end']) ? Carbon::parse($arguments['end']) : null;

                    $form->fill([
                        'day_of_week' => $start->dayOfWeek,
                        'start_time' => $start->format('H:i'),
                        'end_time' => $end?->format('H:i'),
                    ]);
                }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('commercial_id')
                ->label('Commercial')
                ->relationship('commercial', 'name')
                ->required()
                ->searchable()
                ->preload(),
            Forms\Components\Select::make('day_of_week')
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
            Forms\Components\TimePicker::make('start_time')
                ->label('Start')
                ->seconds(false)
                ->required(),
            Forms\Components\TimePicker::make('end_time')
                ->label('End')
                ->seconds(false)
                ->required(),
        ];
    }
}

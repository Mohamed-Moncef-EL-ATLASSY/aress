<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class BookingCalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Booking::class;

    protected static ?string $heading = 'Booking Calendar';

    public function fetchEvents(array $fetchInfo): array
    {
        return Booking::query()
            ->with(['commercial', 'user'])
            ->where('start_at', '<', $fetchInfo['end'])
            ->where('end_at', '>', $fetchInfo['start'])
            ->get()
            ->map(function (Booking $booking): array {
                $commercial = $booking->commercial?->name ?? 'Commercial';
                $client = $booking->user?->name ?? 'Client';

                return [
                    'id' => (string) $booking->id,
                    'title' => sprintf('%s - %s', $commercial, $client),
                    'start' => $booking->start_at,
                    'end' => $booking->end_at,
                    'url' => BookingResource::getUrl('edit', ['record' => $booking]),
                    'backgroundColor' => match ($booking->status) {
                        Booking::STATUS_CONFIRMED => '#0ea5e9',
                        Booking::STATUS_COMPLETED => '#10b981',
                        Booking::STATUS_CANCELLED => '#ef4444',
                        default => '#94a3b8',
                    },
                ];
            })
            ->toArray();
    }

    public function config(): array
    {
        return [
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'left' => 'dayGridMonth,timeGridWeek,timeGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(function (Forms\Form $form, array $arguments): void {
                    $form->fill([
                        'start_at' => $arguments['start'] ?? null,
                        'end_at' => $arguments['end'] ?? null,
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
            Forms\Components\Select::make('user_id')
                ->label('Client')
                ->relationship('user', 'name')
                ->searchable()
                ->preload(),
            Forms\Components\Select::make('status')
                ->required()
                ->options(array_combine(Booking::STATUSES, Booking::STATUSES))
                ->default(Booking::STATUS_REQUESTED),
            Forms\Components\DateTimePicker::make('start_at')
                ->label('Start')
                ->required(),
            Forms\Components\DateTimePicker::make('end_at')
                ->label('End')
                ->required(),
            Forms\Components\Textarea::make('notes')
                ->columnSpanFull()
                ->rows(3)
                ->maxLength(2000),
        ];
    }
}

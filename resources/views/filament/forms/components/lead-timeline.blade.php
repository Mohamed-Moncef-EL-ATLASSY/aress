@php
    $events = $events ?? [];
    $totalMinutes = 0;

    foreach ($events as $event) {
        $duration = $event['duration'] ?? null;
        if (is_string($duration) && strpos($duration, ':') !== false) {
            [$h, $m] = array_pad(explode(':', $duration), 2, 0);
            $totalMinutes += ((int) $h * 60) + (int) $m;
        }
    }

    $hours = intdiv($totalMinutes, 60);
    $minutes = $totalMinutes % 60;
    $totalDuration = sprintf('%dh %02dmin', $hours, $minutes);
@endphp

<div class="space-y-6">
    <div style="padding: 1rem; border-radius: 0.75rem; border: 1px solid #e5e7eb; background: #f9fafb;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="padding: 0.5rem; border-radius: 0.5rem; background: #dbeafe; color: #2563eb;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 0.875rem; color: #6b7280;">Duree totale des evenements</p>
                    <p style="font-size: 1.125rem; font-weight: 600; color: #111827;">{{ $totalDuration }}</p>
                </div>
            </div>
            <div style="text-align: right;">
                <p style="font-size: 0.875rem; color: #6b7280;">Nombre d'evenements</p>
                <p style="font-size: 1.125rem; font-weight: 600; color: #111827;">{{ count($events) }}</p>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @forelse ($events as $event)
            @php
                $eventDate = $event['event_date'] ?? null;
                $eventType = $event['event_type'] ?? 'event';
                $contactStatus = $event['contact_status'] ?? null;
                $representatives = $event['representatives'] ?? null;
                $duration = $event['duration'] ?? null;
                $comment = $event['comment'] ?? null;
                $title = $event['title'] ?? 'Evenement';
            @endphp
            <div style="position: relative; display: flex; gap: 1rem;">
                <div style="position: absolute; left: 1.25rem; top: 2.5rem; height: 100%; width: 0.25rem; background: #e5e7eb;"></div>
                <div style="position: relative; z-index: 10; display: flex; height: 2.5rem; width: 2.5rem; align-items: center; justify-content: center; border-radius: 9999px; background: #3b82f6; color: #ffffff;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div style="flex: 1; border-radius: 0.75rem; border: 1px solid #e5e7eb; background: #ffffff; padding: 1rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.5rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">{{ $title }}</h3>
                        @if ($eventDate)
                            <span style="font-size: 0.75rem; color: #6b7280;">{{ \Illuminate\Support\Carbon::parse($eventDate)->format('d/m/Y H:i') }}</span>
                        @endif
                    </div>
                    <div style="margin-top: 0.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-h-6 py-1 fi-color-custom" style="background-color: rgb(191 219 254); color: rgb(30 64 175); --c-50:rgb(239 246 255);--c-400:rgb(96 165 250);--c-600:rgb(37 99 235);">
                            {{ $eventType }}
                        </span>
                        @if ($contactStatus)
                            <span class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-h-6 py-1 fi-color-custom" style="background-color: rgb(254 240 138); color: rgb(133 77 14); --c-50:rgb(254 252 232);--c-400:rgb(250 204 21);--c-600:rgb(202 138 4);">
                                {{ $contactStatus }}
                            </span>
                        @endif
                    </div>
                    <div style="margin-top: 0.75rem; display: grid; gap: 0.5rem; color: #4b5563; grid-template-columns: repeat(2, minmax(0, 1fr));">
                        @if ($representatives)
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>{{ $representatives }}</span>
                            </div>
                        @endif
                        @if ($duration)
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $duration }}</span>
                            </div>
                        @endif
                    </div>
                    @if ($comment)
                        <p style="margin-top: 0.75rem; font-size: 0.875rem; color: #374151;">{{ $comment }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div style="border-radius: 0.75rem; border: 1px dashed #e5e7eb; background: #f9fafb; padding: 1rem; font-size: 0.875rem; color: #6b7280;">
                Aucun evenement pour le moment.
            </div>
        @endforelse
    </div>
</div>

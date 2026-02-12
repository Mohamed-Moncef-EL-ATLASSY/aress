@php
    $record = $record ?? null;
    $details = $details ?? '';
    $changes = $changes ?? [];
    $userName = $record?->user?->name ?? 'System';
    $action = $record?->action ?? 'updated';
    $eventTime = $record?->created_at?->format('M d, Y H:i') ?? '';

    $badgeStyles = match ($action) {
        'created' => 'background-color: #dcfce7; color: #15803d;',
        'updated' => 'background-color: #dbeafe; color: #1d4ed8;',
        default => 'background-color: #f1f5f9; color: #334155;',
    };

    $dotStyles = match ($action) {
        'created' => 'background-color: #10b981;',
        'updated' => 'background-color: #3b82f6;',
        default => 'background-color: #64748b;',
    };
@endphp

<div class="flex items-center gap-3 bg-white px-3 py-2">
    <div class="flex h-8 w-8 items-center justify-center rounded-full text-white" style="{{ $dotStyles }}">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex flex-1 items-center justify-between gap-4">
        <div class="flex min-w-0">
            <div class="flex flex-wrap items-center gap-2 text-sm font-semibold text-gray-900">
                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold" style="{{ $badgeStyles }}">
                    {{ ucfirst($action) }}
                </span>
                <span class="truncate" style="color: #111827;">{{ $details }}</span>
                <span class="text-xs text-gray-500">by {{ $userName }}</span>
            </div>
            @if (count($changes))
                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-700">
                    @foreach ($changes as $change)
                        @php
                            $field = $change['field'] ?? 'field';
                            $label = $change['label'] ?? ucfirst(str_replace('_', ' ', $field));
                            $before = $change['before'] ?? null;
                            $after = $change['after'] ?? null;
                        @endphp
                        <span class="inline-flex items-center gap-1 rounded-md px-2 py-0.5" style="background-color: #f3f4f6; color: #374151;">
                            <span class="font-semibold text-gray-700">{{ $label }}</span>
                            <span class="text-gray-500">{{ $before === null || $before === '' ? '—' : $before }}</span>
                            <span class="text-gray-400">→</span>
                            <span style="color: #15803d;">{{ $after === null || $after === '' ? '—' : $after }}</span>
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
        <span class="text-xs text-gray-500">{{ $eventTime }}</span>
    </div>
</div>

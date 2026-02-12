@php
    $record = $record ?? null;
    $details = $details ?? '';
    $changes = $changes ?? [];
    $userName = $record?->user?->name ?? 'System';
    $action = $record?->action ?? 'updated';
    $eventTime = $record?->created_at?->format('M d, Y H:i') ?? '';

    $badgeClass = match ($action) {
        'created' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-100 dark:text-emerald-700',
        'updated' => 'bg-blue-100 text-blue-700 dark:bg-blue-100 dark:text-blue-700',
        default => 'bg-slate-100 text-slate-700 dark:bg-slate-100 dark:text-slate-700',
    };

    $dotClass = match ($action) {
        'created' => 'bg-emerald-500',
        'updated' => 'bg-blue-500',
        default => 'bg-slate-500',
    };
@endphp

<div class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-sm dark:border-gray-200 dark:bg-white">
    <div class="flex h-8 w-8 items-center justify-center rounded-full text-white {{ $dotClass }}">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <div class="flex flex-1 items-center justify-between gap-4">
        <div class="flex min-w-0">
            <div class="flex flex-wrap items-center gap-2 text-sm font-semibold text-gray-900 dark:text-gray-900">
                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold {{ $badgeClass }}">
                    {{ ucfirst($action) }}
                </span>
                <span class="truncate">{{ $details }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-600">by {{ $userName }}</span>
            </div>
            @if (count($changes))
                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-700 dark:text-gray-700">
                    @foreach ($changes as $change)
                        @php
                            $field = $change['field'] ?? 'field';
                            $label = $change['label'] ?? ucfirst(str_replace('_', ' ', $field));
                            $before = $change['before'] ?? null;
                            $after = $change['after'] ?? null;
                        @endphp
                        <span class="inline-flex items-center gap-1 rounded-md bg-gray-100 px-2 py-0.5 text-gray-700 dark:bg-gray-100 dark:text-gray-700">
                            <span class="font-semibold text-gray-700 dark:text-gray-700">{{ $label }}</span>
                            <span class="text-gray-500 dark:text-gray-600">{{ $before === null || $before === '' ? '—' : $before }}</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-emerald-700 dark:text-emerald-700">{{ $after === null || $after === '' ? '—' : $after }}</span>
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
        <span class="text-xs text-gray-500 dark:text-gray-600">{{ $eventTime }}</span>
    </div>
</div>

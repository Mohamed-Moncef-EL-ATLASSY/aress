<x-filament-panels::page>
    <style>
        .kanban-board { display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 0.5rem; }
        .kanban-board::-webkit-scrollbar { height: 8px; }
        .kanban-board::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.5); border-radius: 9999px; }
        .kanban-board::-webkit-scrollbar-track { background: transparent; }
        .kanban-column { min-height: 220px; min-width: 280px; max-width: 320px; flex: 0 0 auto; }
        .kanban-column-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .kanban-column-title { font-size: 0.875rem; font-weight: 600; color: rgb(15 23 42); }
        .kanban-column-count { font-size: 0.75rem; color: rgb(100 116 139); }
        .kanban-drop-zone { min-height: 150px; }
        .kanban-card { cursor: grab; }
        .kanban-card:active { cursor: grabbing; }
        .kanban-ghost { opacity: 0.5; }
        .kanban-chosen { box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); }
        .badge { display: inline-flex; align-items: center; gap: 0.25rem; border-radius: 9999px; padding: 0.125rem 0.5rem; font-size: 0.7rem; font-weight: 600; }
        .badge-dot { width: 0.35rem; height: 0.35rem; border-radius: 9999px; background: currentColor; }
        .kanban-card-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 0.5rem; margin-bottom: 0.5rem; }
        .kanban-card-name { font-size: 0.9rem; font-weight: 600; color: rgb(15 23 42); }
        .kanban-card-email { font-size: 0.75rem; color: rgb(100 116 139); }
        .kanban-card-id { font-size: 0.7rem; font-weight: 600; color: rgb(71 85 105); background: rgb(241 245 249); border-radius: 9999px; padding: 0.125rem 0.5rem; }
        .kanban-card-meta { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.5rem; }
        .kanban-card-note { font-size: 0.75rem; color: rgb(100 116 139); }
        .dark .kanban-column-title { color: rgb(241 245 249); }
        .dark .kanban-column-count { color: rgb(148 163 184); }
        .dark .kanban-card-name { color: rgb(241 245 249); }
        .dark .kanban-card-email { color: rgb(148 163 184); }
        .dark .kanban-card-id { color: rgb(226 232 240); background: rgb(30 41 59); }
        .dark .kanban-card-note { color: rgb(148 163 184); }
    </style>

    <div class="kanban-board">

        @foreach ($this->statuses as $status)
            @php
                $columnKey = 'column-' . \Illuminate\Support\Str::slug($status);
                $leads = $this->leadsByStatus[$status] ?? [];
            @endphp
            <div class="kanban-column rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="kanban-column-header">
                    <h3 class="kanban-column-title">{{ $status }}</h3>
                    <span class="kanban-column-count">{{ count($leads) }}</span>
                </div>
                <div class="space-y-3 kanban-drop-zone" data-kanban-column data-status="{{ $status }}" data-column-key="{{ $columnKey }}">
                    @foreach ($leads as $lead)
                        <div
                            class="kanban-card rounded-lg border border-gray-200 bg-white p-3 text-sm shadow-sm transition hover:shadow-md"
                            data-lead-id="{{ $lead->id }}"
                        >
                            <div class="kanban-card-head">
                                <div>
                                    <div class="kanban-card-name">{{ $lead->name }}</div>
                                    <div class="kanban-card-email">{{ $lead->email }}</div>
                                </div>
                                <span class="kanban-card-id">#{{ $lead->id }}</span>
                            </div>
                            <div class="kanban-card-meta">
                                <span class="badge bg-amber-50 text-amber-700">
                                    <span class="badge-dot"></span>
                                    {{ $lead->companySource?->name ?? $lead->company_source }}
                                </span>
                                <span class="badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    <span class="badge-dot"></span>
                                    {{ $lead->phone }}
                                </span>
                            </div>
                            @if ($lead->notes)
                                <div class="kanban-card-note">{{ \Illuminate\Support\Str::limit($lead->notes, 90) }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @once
        @push('scripts')
            <script src="{{ asset('js/sortable.min.js') }}"></script>
            <script>
                const kanbanComponentId = @js($this->getId());

                function initLeadKanban() {
                    if (typeof Sortable === 'undefined') {
                        return;
                    }

                    document.querySelectorAll('[data-kanban-column]').forEach((column) => {
                        if (column._sortable) {
                            column._sortable.destroy();
                        }

                        column._sortable = Sortable.create(column, {
                            group: 'leads-kanban',
                            animation: 150,
                            ghostClass: 'kanban-ghost',
                            chosenClass: 'kanban-chosen',
                            onEnd: (event) => {
                                const leadId = event.item?.dataset?.leadId;
                                const status = event.to?.dataset?.status;

                                if (!leadId || !status) {
                                    return;
                                }

                                const component = window.Livewire?.find(kanbanComponentId);

                                if (!component) {
                                    return;
                                }

                                component.call('updateLeadStatus', parseInt(leadId, 10), status);
                            },
                        });
                    });
                }

                document.addEventListener('DOMContentLoaded', initLeadKanban);
                document.addEventListener('livewire:init', () => {
                    initLeadKanban();

                    if (window.Livewire) {
                        Livewire.hook('morph.updated', () => {
                            initLeadKanban();
                        });
                    }
                });
                document.addEventListener('livewire:navigated', initLeadKanban);
            </script>
        @endpush
    @endonce
</x-filament-panels::page>

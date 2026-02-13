<?php

namespace App\Filament\Resources\LeadsKanbanResource\Pages;

use App\Filament\Resources\LeadsKanbanResource;
use App\Models\Lead;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\Width;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

class ManageLeadsKanban extends Page
{
    protected static string $resource = LeadsKanbanResource::class;

    protected string $view = 'filament.resources.leads.pages.leads-kanban';

    protected Width|string|null $maxContentWidth = Width::Full;

    public array $statuses = [];

    public function mount(): void
    {
        $this->statuses = Lead::STATUSES;
    }

    #[Computed]
    public function leadsByStatus(): array
    {
        return Lead::query()
            ->with('companySource')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('status')
            ->map(fn ($leads) => $leads->values())
            ->all();
    }

    public function updateLeadStatus(int $leadId, string $status): void
    {
        if (! in_array($status, Lead::STATUSES, true)) {
            return;
        }

        $lead = Lead::find($leadId);

        if (! $lead) {
            return;
        }

        $lead->status = $status;
        $lead->save();

        // Skip rendering to keep drag smooth - the DOM is already updated by Sortable.js
        $this->skipRender();
    }
}

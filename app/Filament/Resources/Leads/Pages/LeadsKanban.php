<?php

namespace App\Filament\Resources\Leads\Pages;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\On;

class LeadsKanban extends Page
{
    protected static string $resource = LeadResource::class;

    protected string $view = 'filament.resources.leads.pages.leads-kanban';

    protected static ?string $navigationLabel = 'Leads Kanban';


    public array $statuses = [];

    public function mount(): void
    {
        $this->statuses = Lead::STATUSES;
    }

    public function getLeadsByStatusProperty(): array
    {
        return Lead::query()
            ->with('companySource')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('status')
            ->map(fn ($leads) => $leads->values())
            ->all();
    }

    #[On('lead-status-updated')]
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
    }
}

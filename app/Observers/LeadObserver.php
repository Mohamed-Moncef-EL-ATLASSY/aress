<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\LeadActivity;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class LeadObserver
{
    public function created(Lead $lead): void
    {
        $this->logActivity($lead, 'created', $lead->getAttributes());
    }

    public function updated(Lead $lead): void
    {
        $changes = $lead->getChanges();
        unset($changes['updated_at']);

        if ($changes === []) {
            return;
        }

        $before = [];
        foreach ($changes as $key => $value) {
            $before[$key] = $lead->getOriginal($key);
        }

        $this->logActivity($lead, 'updated', [
            'before' => $before,
            'after' => Arr::only($changes, array_keys($before)),
        ]);
    }

    private function logActivity(Lead $lead, string $action, array $changes): void
    {
        LeadActivity::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'changes' => $changes,
        ]);
    }
}

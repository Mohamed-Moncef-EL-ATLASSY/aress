<?php

namespace App\Filament\Resources\Leads\RelationManagers;

use App\Models\LeadActivity;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class LeadActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $title = 'Timeline';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('timeline')
                    ->view('filament.leads.timeline-row')
                    ->viewData(fn (LeadActivity $record): array => [
                        'record' => $record,
                        'details' => $this->formatChangeDetails($record),
                        'changes' => $this->buildChangeItems($record),
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([])
            ->actions([])
            ->bulkActions([])
            ->paginated([10, 25, 50])
            ->heading(null)
            ->header(fn () => view('filament.leads.timeline-table-style'))
            ->extraAttributes(['class' => 'lead-timeline-table'])
            ->emptyStateHeading('No timeline yet');
    }

    private function formatChangeDetails(LeadActivity $record): string
    {
        $state = $record->changes;
        $keys = [];

        if (is_string($state)) {
            $parts = array_map('trim', explode(',', $state));
            foreach ($parts as $part) {
                $part = preg_replace('/^(Created|Updated|Changed):\s*/', '', $part);
                if ($part !== '') {
                    $keys[] = $part;
                }
            }
        } elseif (is_array($state)) {
            if (isset($state['after']) && is_array($state['after'])) {
                $keys = array_keys($state['after']);
            } elseif (array_is_list($state)) {
                foreach ($state as $item) {
                    if (is_string($item)) {
                        $item = preg_replace('/^(Created|Updated|Changed):\s*/', '', $item);
                        if ($item !== '') {
                            $keys[] = $item;
                        }
                    } elseif (is_array($item)) {
                        $keys = array_merge($keys, array_keys($item));
                    }
                }
            } else {
                $keys = array_keys($state);
            }
        }

        $keys = array_values(array_unique(array_filter($keys)));
        $keyList = $keys ? implode(', ', $keys) : null;

        return match ($record->action) {
            'created' => $keyList ? 'Created: ' . $keyList : 'Created',
            'updated' => $keyList ? 'Updated: ' . $keyList : 'Updated',
            default => $keyList ? 'Changed: ' . $keyList : 'Changed',
        };
    }

    /** @return array<int, array<string, mixed>> */
    private function buildChangeItems(LeadActivity $record): array
    {
        $state = $record->changes;
        $items = [];

        $labels = [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'company_source' => 'Company Source',
            'company_source_id' => 'Company Source',
            'status' => 'Status',
            'notes' => 'Notes',
        ];

        if (is_array($state) && isset($state['before'], $state['after'])) {
            foreach ((array) $state['after'] as $field => $after) {
                $before = $state['before'][$field] ?? null;
                $items[] = [
                    'field' => $field,
                    'label' => $labels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                    'before' => $before,
                    'after' => $after,
                ];
            }
        } elseif (is_array($state)) {
            foreach ($state as $field => $after) {
                if (is_int($field)) {
                    continue;
                }

                $items[] = [
                    'field' => $field,
                    'label' => $labels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                    'before' => null,
                    'after' => $after,
                ];
            }
        }

        return $items;
    }
}

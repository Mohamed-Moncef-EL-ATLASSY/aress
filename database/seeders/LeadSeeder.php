<?php

namespace Database\Seeders;

use App\Models\CompanySource;
use App\Models\Lead;
use App\Models\LeadActivity;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadActivity::query()->delete();
        Lead::query()->delete();

        $sources = CompanySource::query()->pluck('id', 'name');

        $leads = [
            [
                'name' => 'Moncef Elatlassy',
                'email' => 'moncef.elatlassy@gmail.com',
                'phone' => '+212 6 12 34 56 78',
                'company_source' => 'Referral',
                'company_source_id' => $sources['Referral'] ?? null,
                'status' => Lead::STATUS_INTERESTED,
                'notes' => 'Interested in partnership options.',
            ],
            [
                'name' => 'Salma Ait Lahcen',
                'email' => 'salma.aitlahcen@example.ma',
                'phone' => '+212 6 98 76 54 32',
                'company_source' => 'LinkedIn',
                'company_source_id' => $sources['LinkedIn'] ?? null,
                'status' => Lead::STATUS_CONTACTED,
                'notes' => 'Asked for pricing and timelines.',
            ],
            [
                'name' => 'Youssef Benjelloun',
                'email' => 'youssef.benjelloun@example.ma',
                'phone' => '+212 6 55 11 22 33',
                'company_source' => 'Cold call',
                'company_source_id' => $sources['Cold call'] ?? null,
                'status' => Lead::STATUS_NEW,
                'notes' => 'Initial outreach pending.',
            ],
            [
                'name' => 'Nadia El Fassi',
                'email' => 'nadia.elfassi@example.ma',
                'phone' => '+212 6 44 33 22 11',
                'company_source' => 'Website',
                'company_source_id' => $sources['Website'] ?? null,
                'status' => Lead::STATUS_NEGOTIATION,
                'notes' => 'Negotiating contract scope.',
            ],
            [
                'name' => 'Hicham Ouarzazi',
                'email' => 'hicham.ouarzazi@example.ma',
                'phone' => '+212 6 22 33 44 55',
                'company_source' => 'Email outreach',
                'company_source_id' => $sources['Email outreach'] ?? null,
                'status' => Lead::STATUS_WON,
                'notes' => 'Won after demo and follow-up.',
            ],
        ];

        foreach ($leads as $lead) {
            Lead::create($lead);
        }
    }
}

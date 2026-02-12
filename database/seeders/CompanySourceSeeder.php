<?php

namespace Database\Seeders;

use App\Models\CompanySource;
use Illuminate\Database\Seeder;

class CompanySourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'LinkedIn',
            'Referral',
            'Cold call',
            'Email outreach',
            'Website',
            'Other',
        ];

        foreach ($sources as $source) {
            CompanySource::firstOrCreate(['name' => $source]);
        }
    }
}

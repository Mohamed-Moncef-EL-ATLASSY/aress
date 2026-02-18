<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'moncef.elatlassy@gmail.com'],
            [
                'name' => 'Moncef Elatlassy',
                'password' => 'moncef.elatlassy',
                'email_verified_at' => Carbon::now(),
            ]
        );

        $this->call(CompanySourceSeeder::class);
        $this->call(LeadSeeder::class);
        $this->call(CommercialSeeder::class);
    }
}

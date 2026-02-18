<?php

namespace Database\Seeders;

use App\Models\Commercial;
use App\Models\CommercialAvailability;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommercialSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $commercials = collect();

        for ($i = 0; $i < 5; $i++) {
            $commercials->push(Commercial::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'headline' => $faker->sentence(4),
                'bio' => $faker->paragraph(2),
                'hourly_rate' => $faker->randomFloat(2, 150, 600),
                'active' => true,
            ]));
        }

        $commercials->each(function (Commercial $commercial) use ($faker): void {
            $days = collect(range(0, 6))
                ->shuffle()
                ->take(random_int(2, 4));

            foreach ($days as $dayOfWeek) {
                $startHour = random_int(8, 14);
                $endHour = $startHour + random_int(2, 4);

                CommercialAvailability::create([
                    'commercial_id' => $commercial->id,
                    'day_of_week' => $dayOfWeek,
                    'start_time' => sprintf('%02d:00:00', $startHour),
                    'end_time' => sprintf('%02d:00:00', $endHour),
                ]);
            }
        });
    }
}

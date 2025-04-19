<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Season;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $i) {
            Season::create([
                'id' => $faker->unique()->numberBetween(1, 10),
                'season_name' => $faker->sentence(),
                'season_order' => $faker->numberBetween(1, 10),
                'video_id' => $faker->numberBetween(1, 10)
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Episode;

class EpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            Episode::create([
                'episode_order' => $faker->numberBetween(1, 10),
                'season_id' => $faker->numberBetween(1, 10),
                'video_id' => $faker->numberBetween(1, 10)
            ]);
        }
    }
}

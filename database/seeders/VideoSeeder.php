<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        foreach (range(1, 10) as $index) {
            Video::create([
                'title' => $fake->sentence(),
                'duration' => $fake->numberBetween(1, 100),
                'description' => $fake->paragraph()
            ]);
        }
    }
}

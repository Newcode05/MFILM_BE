<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\Categories;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class CategoriesVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        $video = Video::all();
        $categories = Categories::all();
        $privot = [];
        foreach ($video as $videoItem) {
            $videoId = $fake->randomElement($video->pluck('id')->toArray());
            $categoriesId = $fake->randomElement($categories->pluck('id')->toArray());
            $item = $videoId . "-" . $categoriesId;
            if (!in_array($item, $privot)) {
                DB::table('categories_video')->insert([
                    'video_id' => $videoId,
                    'categories_id' => $categoriesId,
                ]);
                $privot[] = $item;
            } else {
                continue;
            }
        }
    }
}

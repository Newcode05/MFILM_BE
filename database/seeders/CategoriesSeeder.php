<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;
use Faker\Factory as Faker;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        foreach (range(1, 7) as $index) {
            Categories::create([
                'type' => $fake->unique()->randomElement(['Emoltional', 'Dramtic', 'Act', 'Psychology', 'Detective', 'Cartoon 3D','Romatic']),
            ]);
        }
    }
}

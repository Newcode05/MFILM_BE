<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Fake;

use Database\Seeders\VideoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class
        ]);
        // User::factory(10)->create();
        $fake = Fake::create();
        foreach (range(1, 10) as $index) {
            User::factory()->create([
                'name' => $fake->sentence(),
                'email' => $fake->safeEmail(),
            ]);
        }
    }
}

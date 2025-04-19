<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoriesVideo>
 */
class CategoriesVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'video_id' => $this->faker->numberBetween(1, 5),
            'categories_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}

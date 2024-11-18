<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Kleid', 'Pullover', 'Hose', 'Handtasche'], 1, true),
            'price' => fake()->randomFloat(2, 10, 100),
            'status' => fake()->randomElement([0, 1]),
            'description' => fake()->sentence(),
            'category_id' => Category::factory()
        ];
    }
}

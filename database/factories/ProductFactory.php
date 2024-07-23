<?php

namespace Database\Factories;

use App\Models\User;
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
            //
            'userID' => User::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(5),
            'prodImage' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'featured' => $this->faker->boolean(10),
        ];
    }
}

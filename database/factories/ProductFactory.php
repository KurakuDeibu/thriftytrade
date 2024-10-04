<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
            'prodRefTag' => Str::random(10),
            'productName' => $this->faker->word,
            'prodDescription' => $this->faker->paragraph,
            'prodPrice' => $this->faker->randomFloat(2, 10, 1000),
            'prodQuantity' => $this->faker->numberBetween(1, 100),
            'prodCondition' => $this->faker->word,
            'categID' => Category::factory(),  // Automatically create a category
            'sellerID' => User::factory(),  // Automatically create a seller (user)
        ];
    }
}
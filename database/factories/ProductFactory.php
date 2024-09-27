<?php

namespace Database\Factories;

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
        $conditionType = ['New', 'Likely New', 'Used', 'Likely Used'];
        // $category = ['Want a Buyer', 'Want a Seller', 'Featured', 'Vehicles', 'Others'];


        return [
            //
            'user_id' => User::factory(),
            'prodName' => $this->faker->sentence(),
            'slug' => $this->faker->slug(5),
            'prodImage' => $this->faker->imageUrl(),
            'prodPrice' => $this->faker->randomFloat(2, 0, 100),
            'prodDescription' => $this->faker->paragraph(3),
            'prodCondition' => $this->faker->randomElement($conditionType),
            'prodCommissionFee' => $this->faker->randomFloat(2, 0, 100),
            'prodRefTag' => Str::random(10),

            // 'prodCondition' => $this->faker->randomElement($conditionType),
            
            'featured' => $this->faker->boolean(10),

            // 'user_id' => User::factory(),
            // 'title' => $this->faker->sentence(),
            // 'slug' => $this->faker->slug(5),
            // 'prodImage' => $this->faker->imageUrl(),
            // 'description' => $this->faker->paragraph(3),
            // 'price' => $this->faker->randomFloat(2, 0, 100),
            // 'featured' => $this->faker->boolean(10),
        ];
    }
}

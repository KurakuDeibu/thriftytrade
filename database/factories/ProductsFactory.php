<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
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
            'category_id' => Category::factory(),
            'prodImage' => $this->faker->imageUrl(),
            // 'productimages_id' => ProductImage::factory(),
            'prodPrice' => $this->faker->randomFloat(2, 0, 100),
            'prodDescription' => $this->faker->paragraph(2),
            'prodCondition' => $this->faker->randomElement($conditionType),
            'featured' => $this->faker->boolean(10),
        ];
    }
}
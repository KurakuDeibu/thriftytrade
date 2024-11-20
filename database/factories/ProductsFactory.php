<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Status;
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
        $conditionType = ['New', 'Likely-New', 'Used', 'Likely-Used'];
        $locations = ['Lapu-Lapu City', 'Mandaue City'];
        $status = ['Available', 'Pending', 'Sold'];
        $priceType = ['Fixed', 'Negotiable'];

        return [
        'prodName' => $this->faker->word,
        'prodPrice' => $this->faker->randomFloat(2, 1, 1000),
        'prodQuantity' => $this->faker->numberBetween(1, 100),
        'prodCondition' => $this->faker->randomElement($conditionType),
        'location' => $this->faker->randomElement($locations),
        'status' => $this->faker->randomElement($status),
        'price_type' => $this->faker->randomElement($priceType),
        'prodImage' => $this->faker->imageUrl(),
        'prodDescription' => $this->faker->paragraph,
        'featured' => $this->faker->boolean,
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'category_id' => function () {
            return Category::inRandomOrder()->first()->id;
               }];
    }
}

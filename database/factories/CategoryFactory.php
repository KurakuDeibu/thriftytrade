<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categName' => 'Electronics', // default state
        ];
    }

    public function createAllCategories()
    {
        $categoryNames = [
            'Electronics',
            'Clothing',
            'Books',
            'Home & Garden',
            'Sports',
            'Toys',
            'Health & Wellness',
            'Office Supplies',
            'Pet Supplies',
        ];

        foreach ($categoryNames as $categoryName) {
            Category::create(['categName' => $categoryName]);
        }
    }
}
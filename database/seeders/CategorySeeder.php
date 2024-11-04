<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Electronics',
            'Books',
            'Appliances',
            'Clothing',
            'Sports & Outdoors',
            'Toys & Games',
            'Automotive',
        ];

        foreach ($categories as $index => $categoryName) {
            Category::create(['categName' => $categoryName]);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Products;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             // Ensure we have users, categories, and statuses
                User::factory(5)->create();
                // Create 50 products
             Products::factory(50)->create([
                 'user_id' => fn() => User::inRandomOrder()->first()->id,
                 'category_id' => fn() => Category::inRandomOrder()->first()->id,
                 'status_id' => fn() => Status::inRandomOrder()->first()->id,
             ]);
    }
}
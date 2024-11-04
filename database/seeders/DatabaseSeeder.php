<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Products;
use App\Models\Status;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Database\Factories\StatusFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            StatusSeeder::class,
            ProductsSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
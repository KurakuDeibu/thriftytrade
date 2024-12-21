<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 10 users
        User::factory(10)->create();

        // Optionally, create a specific admin user
        User::create([
            'name' => 'THRIFTYTRADE ADMIN',
            'firstName' => 'Admin',
            'lastName' => 'User ',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminpassword'), // Use a secure password
            'birthDay' => '1990-01-01',
            'userAddress' => '123 Admin St, Admin City',
            'phoneNum' => '123-456-7890',
            'email_verified_at' => now(),
            'isAdmin' => true,
            'isFinder' => true,
            'finder_status' => 'approved',
        ]);
    }
}
<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'statusName' => 'Available', // default state
        ];
    }

    public function createAllStatuses()
    {
        $statusNames = [
            'Available',
            'Negotiable',
            'Pending',
            'Sold',
            'Rush',
        ];

        foreach ($statusNames as $statusName) {
            Status::create(['statusName' => $statusName]);
        }
    }
}
<?php

namespace Database\Factories;

use App\Models\Budding;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Budding>
 */
final class BuddingFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-4 hours', '+4 hours');
        return [
            'start_at' => fake()->dateTimeBetween('-4 hours', '+4 hours'),
            'end_at' => fake()->dateTimeBetween($start, '+6 hours'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Trainee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

final class TraineeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'mail' => fake()->email,
            'capabilities' => fake()->numberBetween(1, 100),
            'is_office' => fake()->boolean,
            'is_active' => true,
            'study_start_at' => Carbon::today(),
            'study_end_at' => Carbon::today()->addDays(19),
            'group_after' => '2_08_Полковникова',
        ];
    }
}

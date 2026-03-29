<?php

namespace Database\Factories;

use App\Enums\Users\JobTitle;
use App\Enums\Users\RoleType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'contact' => [
                'phone' => fake()->phoneNumber(),
                'jobTitle' => JobTitle::MT,
            ],
            'role' => RoleType::Mentor->value,
            'remote' => false,
            'is_active' => true,
            'vacation_until' => null,
            'last_login_at' => now(),
            'email_verified_at' => now(),
        ];
    }
}

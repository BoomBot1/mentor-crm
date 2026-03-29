<?php

namespace Database\Seeders;

use App\Enums\Users\JobTitle;
use App\Enums\Users\RoleType;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        $group = Group::factory()->create();
        User::query()
            ->create($this->getLeadingSpecialistsData($group));
        User::query()
            ->create($this->getLeadingSpecialistsData($group));
        User::query()
            ->create($this->getLeadingSpecialistsData($group));
        User::query()
            ->create([
                'id' => Str::uuid()->toString(),
                'group_id' => $group->id,
                'contact' => [
                    'phone' => fake()->phoneNumber,
                    'jobTitle' => JobTitle::GL,
                ],
                'name' => fake()->name,
                'email' => fake()->email,
                'role' => RoleType::Backoffice->value,
                'remote' => false,
                'is_active' => true,
                'last_login_at' => now(),
                'last_action_at' => now(),
            ]);

        User::factory()
            ->for($group)
            ->count(28)
            ->create();
    }

    private function getLeadingSpecialistsData(Group $group): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'group_id' => $group->id,
            'contact' => [
                'phone' => fake()->phoneNumber,
                'jobTitle' => JobTitle::LS,
            ],
            'name' => fake()->name,
            'email' => fake()->email,
            'role' => RoleType::Backoffice->value,
            'remote' => false,
            'is_active' => true,
            'last_login_at' => now(),
            'last_action_at' => now(),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Trainee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class TraineeSeeder extends Seeder
{
    public function run(): void
    {
        $group = Group::query()
        ->create([
            'id' => Str::uuid()->toString(),
            'name' => 'Группа_Абоба',
        ]);

        Trainee::factory()
            ->for($group)
            ->count(10)
            ->create();
    }
}

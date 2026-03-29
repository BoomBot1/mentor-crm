<?php

namespace App\Repositories;

use App\DTOs\Api\v1\Users\BackofficeInfoDTO;
use App\DTOs\Api\v1\Users\MentorInfoDTO;
use App\DTOs\Api\v1\Users\TrainerInfoDTO;
use App\Enums\Users\RoleType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final readonly class UserRepository
{
    public function baseQuery(): Builder
    {
        return User::query();
    }

    public function findByEmail(string $userEmail): ?User
    {
        return $this
            ->baseQuery()
            ->where('email', $userEmail)
            ->first();
    }

    public function getMentorInfo(User $user): MentorInfoDTO
    {
        $group = $user->group;
        $buddings = $user
            ->getBuddingsToday()
            ->load('trainee');
        $trainees = $buddings
            ->pluck('trainee')
            ->unique();

        return new MentorInfoDTO(
            user: $user,
            buddings: $buddings,
            trainees: $trainees,
            group: $group,
        );
    }

    public function getBackofficeInfo(User $user): BackofficeInfoDTO
    {
        $group = $user->group;
        $mentors = $group
            ->users
            ->where('role', RoleType::Mentor->value)
            ->collect();

        return new BackofficeInfoDTO(
            user: $user,
            mentors: $mentors,
            group: $group,
        );
    }

    public function getTrainerInfo(User $user): TrainerInfoDTO
    {
        $group = $user->group;
        $trainees = $group
            ->trainees
            ->collect();

        return new TrainerInfoDTO(
            user: $user,
            trainees: $trainees,
            group: $group,
        );
    }
}

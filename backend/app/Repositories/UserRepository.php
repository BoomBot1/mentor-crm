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
        $buddings = $user
            ->getBuddingsToday()
            ->load('trainee');
        $trainees = $buddings
            ->pluck('trainee')
            ->unique();
        dd($buddings, $trainees);
        return new MentorInfoDTO(
            user: $user,
            buddings: $buddings,
            trainees: $trainees
        );
    }

    public function getBackofficeInfo(User $user): BackofficeInfoDTO
    {
        $mentors = $user
            ->group
            ->users
            ->where('role', RoleType::Mentor->value)
            ->collect();

        return new BackofficeInfoDTO(
            user: $user,
            mentors: $mentors,
        );
    }

    public function getTrainerInfo(User $user): TrainerInfoDTO
    {
        $trainees = $user
            ->group
            ->trainees
            ->collect();

        return new TrainerInfoDTO(
            user: $user,
            trainees: $trainees,
        );
    }
}

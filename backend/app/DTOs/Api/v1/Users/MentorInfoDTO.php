<?php

namespace App\DTOs\Api\v1\Users;

use App\DTOs\IsUserDataDTO;
use App\Models\Budding;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Support\Collection;

final readonly class MentorInfoDTO implements IsUserDataDTO
{
    /**
     * @param User $user
     * @param Collection<Budding> $buddings
     * @param Collection<Trainee> $trainees
     */
    public function __construct(
        public readonly User $user,
        public readonly Collection $buddings,
        public readonly Collection $trainees,
    ) {
    }
}

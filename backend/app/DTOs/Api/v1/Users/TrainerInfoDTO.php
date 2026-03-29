<?php

namespace App\DTOs\Api\v1\Users;

use App\DTOs\IsUserDataDTO;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Support\Collection;

final readonly class TrainerInfoDTO implements IsUserDataDTO
{
    /**
     * @param User $user
     * @param Collection<Trainee> $trainees
     */
    public function __construct(
        public readonly User $user,
        public readonly Collection $trainees,
    ) {
    }
}

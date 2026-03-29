<?php

namespace App\DTOs\Api\v1\Users;

use App\DTOs\IsUserDataDTO;
use App\Models\User;
use Illuminate\Support\Collection;

final readonly class BackofficeInfoDTO implements IsUserDataDTO
{
    /**
     * @param User $user
     * @param Collection<User> $mentors
     */
    public function __construct(
        public readonly User $user,
        public readonly Collection $mentors,
    ) {
    }
}

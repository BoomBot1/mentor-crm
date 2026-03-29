<?php

namespace App\Services\Api\v1\Users;

use App\DTOs\IsUserDataDTO;
use App\Enums\Users\RoleType;
use App\Models\User;
use App\Repositories\UserRepository;

final readonly class UserService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function getAccount(User $user, RoleType $role): ?IsUserDataDTO
    {
        switch ($role) {
            case RoleType::Backoffice:
                return $this
                    ->repository
                    ->getBackofficeInfo($user);

            case RoleType::Mentor:

                return $this
                    ->repository
                    ->getMentorInfo($user);

            case RoleType::Trainer:
                return $this->repository->getTrainerInfo($user);
            default:
                return null;
        }
    }
}

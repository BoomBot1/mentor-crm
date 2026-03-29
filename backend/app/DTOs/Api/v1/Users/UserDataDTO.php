<?php

namespace App\DTOs\Api\v1\Users;

use Illuminate\Support\Collection;

final readonly class UserDataDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly Collection $contact,
        public readonly string $email,
        //todo здесь нужно добавить ?расписание
        //todo так же нужно добавить ?свою группу
        //todo так же нужно добавить ?своих пиздюков
    ) {
    }
}

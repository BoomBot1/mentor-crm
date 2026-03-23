<?php

namespace App\DTOs\Api\v1\Auth;

final readonly class EmailCodeDTO
{
    public function __construct(
        public readonly string $payload,
        public readonly string $code,
    ) {
    }
}

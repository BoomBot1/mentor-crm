<?php

namespace App\DTOs\Api\v1\Auth;

use Illuminate\Support\Carbon;
use Laravel\Sanctum\Contracts\HasApiTokens;

final readonly class TokensDTO
{
    public function __construct(
        public string $model,
        public string $tokenType,
        public string $accessToken,
        public string $refreshToken,
        public Carbon $accessTokenExpiresAt,
        public Carbon $refreshTokenExpiresAt,
        public HasApiTokens $tokenable,
    ) {
    }
}

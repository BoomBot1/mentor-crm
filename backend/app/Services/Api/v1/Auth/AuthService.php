<?php

namespace App\Services\Api\v1\Auth;

use App\DTOs\Api\v1\Auth\EmailCodeDTO;
use App\DTOs\Api\v1\Auth\TokensDTO;
use App\Enums\VerificationCode\CodePurposeType;
use App\Models\Contracts\HasApiTokens;
use App\Models\PersonalRefreshToken;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Api\v1\SanctumRefreshTokens\TokenService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Login;

final readonly class AuthService
{
    public function sendCode(
        string          $payload,
        CodePurposeType $purposeType,
    ): void
    {
        app(VerificationCodeService::class)
            ->sendCode($payload, $purposeType);
    }

    public function auth(
        EmailCodeDTO    $loginDTO,
        CodePurposeType $purposeType,
    ): TokensDTO
    {
        $user = app(UserRepository::class)
            ->findByEmail($loginDTO->payload);

        if (!$user) {
            $user = User::query()
                ->create([
                    'email' => $loginDTO->payload,
                ]);
        }

        app(VerificationCodeService::class)
            ->markCodeAsUsed($loginDTO->payload, $purposeType);

        return new TokenService($user)->createTokens();
    }

    public function logout(HasApiTokens $tokenable): void
    {
        new TokenService($tokenable)
            ->createTokens();
    }

    public function refresh(string $refreshToken): TokensDTO
    {
        $personalRefreshToken = PersonalRefreshToken::findToken($refreshToken);

        if (!$personalRefreshToken) {
            throw new AuthenticationException();
        }

        $tokenDTO = new TokenService($personalRefreshToken->tokenable)
            ->createTokens();

        event(new Login('sanctum', $personalRefreshToken->tokenable, remember: false));

        $personalRefreshToken->delete();

        return $tokenDTO;
    }
}

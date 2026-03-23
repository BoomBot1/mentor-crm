<?php

namespace App\Services\Api\v1\Auth;

use App\Enums\VerificationCode\CodePurposeType;
use App\Events\SendVerificationCodeEvent;
use App\Exceptions\VerificationCodeException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

final readonly class VerificationCodeService
{
    public function isCodeValid(
        string          $payload,
        string          $code,
        CodePurposeType $purposeType,
    ): bool
    {
        $codeCached = Cache::get($this->getCodeCachedKey($payload, $purposeType));

        return $codeCached === $code;
    }

    public function getCodeCachedKey(
        string          $payload,
        CodePurposeType $purposeType,
    ): string
    {
        return implode(
            ':',
            [
                'code',
                $purposeType->value,
                $payload,
            ]
        );
    }

    public function getCooldownKey(
        string          $payload,
        CodePurposeType $purposeType,
    ): string
    {
        return implode(
            ':',
            [
                'code',
                $purposeType->value,
                $payload,
                'cooldown'
            ]
        );
    }

    public function sendCode(
        string          $payload,
        CodePurposeType $purposeType,
    ): void
    {
        $cacheKey = $this->getCodeCachedKey($payload, $purposeType);
        $cooldownKey = $this->getCooldownKey($payload, $purposeType);

        if (Cache::has($cooldownKey)) {
            throw new VerificationCodeException(
                __('validation.custom.code.too_many_requests'),
                '429'
            );
        }

        $code = $this->getNewCode();
        $expireAt = $this->getNewExpireTime();
        $resending = $this->getResendingDelay();

        Cache::put(
            $cacheKey,
            $code,
            $expireAt,
        );

        Cache::put(
            $cooldownKey,
            true,
            $resending,
        );

        Log::debug("Sent code '{$code}' to '{$payload}' for '{$purposeType->value}'");

        event(
            new SendVerificationCodeEvent(
                payload: $payload,
                code: $code,
                purposeType: $purposeType,
            )
        );
    }

    public function markCodeAsUsed(
        string          $payload,
        CodePurposeType $purposeType,
    ): void {
        Cache::forget($this->getCodeCachedKey($payload, $purposeType));
    }

    public function getNewCode(): string
    {
        return (string)random_int(100000, 999999);
    }

    protected function getResendingDelay(): int
    {
        return config('auth.code.resending_delay');
    }

    protected function getNewExpireTime(): Carbon
    {
        return now()->addMinutes(10);
    }

}

<?php

namespace App\Rules;

use App\Enums\VerificationCode\CodePurposeType;
use App\Services\Api\v1\Auth\VerificationCodeService;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

final class IsLoginCodeValidRule implements DataAwareRule, ValidationRule
{
    private string $email;

    public function setData(array $data): void
    {
        Validator::validate(
            $data,
            [
                'email' => ['required', 'email'],
            ]
        );

        $this->email = Arr::get($data, 'email');
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isValid = app(VerificationCodeService::class)
            ->isCodeValid($this->email, $value, CodePurposeType::Auth);

        if (!$isValid) {
            $fail(__('validation.custom.invalid_code'));
        }
    }
}

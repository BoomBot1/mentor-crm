<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\DTOs\Api\v1\Auth\EmailCodeDTO;
use App\Rules\IsLoginCodeValidRule;
use Illuminate\Foundation\Http\FormRequest;

final class UserAuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            /**
             * Email
             *
             * @example example@nonage.site
             */
            'email' => ['required', 'string', 'email', 'max:255'],

            /*
             * Код подтверждения
             *
             * @example 123123
             */
            'code' => [
                'required',
                'string',
                'min:6',
                'max:6',
                new IsLoginCodeValidRule,
            ],
        ];
    }

    public function getData(): EmailCodeDTO
    {
        return new EmailCodeDTO(
            payload: $this->validated('email'),
            code: $this->validated('code'),
        );
    }
}

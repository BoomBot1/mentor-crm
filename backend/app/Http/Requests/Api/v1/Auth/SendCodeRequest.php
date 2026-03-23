<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            /**
             * Email
             *
             * @example example@exapmle.com
             */
            'email' => [
                'required',
                'string',
                'email',
                'max:255'
            ],
        ];
    }

    public function getData(): string
    {
        return $this->validated('email');
    }
}

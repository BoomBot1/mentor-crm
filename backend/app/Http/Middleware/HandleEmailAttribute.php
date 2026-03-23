<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Illuminate\Support\Str;

final class HandleEmailAttribute extends TransformsRequest
{
    protected array $transform = [
        'email',
    ];

    protected function transform($key, $value): mixed
    {
        if (!$this->shouldTransform($key) || !is_string($value)) {
            return $value;
        }

        return Str::replace(' ', '', Str::lower($value));
    }

    protected function shouldTransform($key): bool
    {
        return in_array($key, $this->transform, true);
    }
}

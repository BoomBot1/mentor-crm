<?php

namespace App\ValueObjects;

use App\Casts\AsUserContactsCollection;
use App\Enums\Users\JobTitle;

final class UserContactValueObject extends BaseValueObject
{
    public function __construct(
        public readonly JobTitle $jobTitle,
        public readonly string $phone,
    ){
    }

    public static function castUsing(array $arguments): string
    {
        return AsUserContactsCollection::class;
    }

    public static function fromArray(array $data): BaseValueObject
    {
        return new self(
            JobTitle::tryFrom($data['jobTitle']) ?? '',
            $data['phone'],
        );
    }

    public function toArray(): array
    {
        return [
            'jobTitle' => $this->jobTitle->value,
            'phone' => $this->phone,
        ];
    }
}

<?php

namespace App\Casts;

use App\ValueObjects\UserContactValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class AsUserContactsCollection implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): Collection
    {
        $data = json_decode($value, true) ?? [];

        return collect(
            array_map(
                function (array $item): UserContactValueObject {
                    return UserContactValueObject::fromArray($item);
                },
                $data
            )
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        $value = $value instanceof Collection
            ? $value->toArray()
            : $value;

        return json_encode($value);
    }
}

<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @mixin FormRequest
 */
trait HasTranslatedAttribute
{
    public function attributes(): array
    {
        return collect($this->rules())
            ->keys()
            ->flatMap(function ($key) {
                return [$key => $this->resolveAttributeTranslation($key)];
            })
            ->all();
    }

    protected function resolveAttributeTranslation(string $key): string
    {
        $segments = collect(explode('.', $key));

        $candidates = collect();

        for ($i = $segments->count(); $i > 0; $i--) {
            $slice = $segments->slice(0, $i);
            $candidates->push(
                $this->getAttributeTranslationPrefix() . '.' . $slice->implode('.'),
                $this->getAttributeTranslationPrefix() . '.' . $slice->map(fn($seg) => is_numeric($seg) ? '*' : $seg)->implode('.')
            );
        }

        $candidates->push($this->getAttributeTranslationPrefix() . '.' . $segments->last());

        $translate = $candidates
            ->map(fn($candidate) => __($candidate))
            ->first(fn($translated, $index) => $translated !== $candidates[$index]);

        if (filled($translate)) {
            return $translate;
        }

        return Str::headline($segments->last());
    }

    private function getAttributeTranslationPrefix(): string
    {
        return 'validation.attributes';
    }
}

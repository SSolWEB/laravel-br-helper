<?php

namespace SSolWEB\LaravelBrFormatter\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use SSolWEB\StringMorpher\StringMorpher as SM;

class CnpjCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return SM::maskBrCnpj($value)
            ->getString();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return SM::onlyNumbers($value)
            ->sub(0, 14)
            ->getString();
    }
}

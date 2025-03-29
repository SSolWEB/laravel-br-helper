<?php

namespace SSolWEB\LaravelBrFormatter\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use SSolWEB\StringMorpher\StringMorpher as SM;

class TelefoneCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return SM::maskBrPhone($value)
            ->getString();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $value = SM::onlyNumbers($value);

        return SM::onlyNumbers($value)
            ->sub(0, 11)
            ->getString();
    }
}

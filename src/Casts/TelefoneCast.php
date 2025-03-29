<?php

namespace SSolWEB\LaravelBrFormatter\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use SSolWEB\StringMorpher\StringMorpher as SM;

class TelefoneCast implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param \Illuminate\Database\Eloquent\Model  $model Modelo.
     * @param string $key Key.
     * @param mixed $value Value to be casted.
     * @param array<string, mixed> $attributes Atributes.
     * @return mixed
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return SM::maskBrPhone($value)
            ->getString();
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param \Illuminate\Database\Eloquent\Model  $model Modelo.
     * @param string $key Key.
     * @param mixed $value Value to be casted.
     * @param array<string, mixed> $attributes Atributes.
     * @return mixed
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $value = SM::onlyNumbers($value);

        return SM::onlyNumbers($value)
            ->sub(0, 11)
            ->getString();
    }
}

<?php

namespace SSolWEB\LaravelBrHelper\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Enums\DBType;
use SSolWEB\LaravelBrHelper\Traits\DBTypeTrait;
use SSolWEB\StringMorpher\StringMorpher as SM;

class CepCast implements CastsAttributes
{
    use DBTypeTrait;

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
        if (is_null($value)) {
            return $value;
        }
        $smValue = match ($this->dbType) {
            DBType::INTEGER => SM::onlyNumbers($value)->padL(8, '0'),
            DBType::FORMATTED => SM::onlyNumbers($value),
            // DBType::STRING is default
            default => SM::make($value),
        };
        return $smValue->maskBrCep()->getString();
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
        if (is_null($value)) {
            return $value;
        }
        return match ($this->dbType) {
            DBType::INTEGER => (int) SM::onlyNumbers($value)->getString(),
            DBType::FORMATTED => SM::onlyNumbers($value)->sub(0, 8)->maskBrCep()->getString(),
            // DBType::STRING is default
            default => SM::onlyNumbers($value)->sub(0, 8)->padL(8, '0')->getString(),
        };
    }
}

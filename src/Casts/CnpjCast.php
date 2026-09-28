<?php

namespace SSolWEB\LaravelBrHelper\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Enums\DBType;
use SSolWEB\LaravelBrHelper\Traits\DBTypeTrait;
use SSolWEB\StringMorpher\StringMorpher as SM;

class CnpjCast implements CastsAttributes
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
        if (empty($value) || (!is_string($value) && !is_int($value))) {
            return null;
        }

        $cleanValue = SM::replaceRegex((string) $value, '/[^A-Za-z0-9]/', '')->toUpper()->getString();

        $smValue = match ($this->dbType) {
            DBType::INTEGER => SM::onlyNumbers((string) $value)->padL(14, '0'),
            // DBType::FORMATTED and DBType::STRING
            default => SM::make($cleanValue)->padL(14, '0'),
        };

        return $smValue->maskBrCnpj()->getString();
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
        if (empty($value) || (!is_string($value) && !is_int($value))) {
            return null;
        }

        $cleanValue = SM::replaceRegex((string) $value, '/[^A-Za-z0-9]/', '')
            ->toUpper()
            ->sub(0, 14)
            ->padL(14, '0')
            ->getString();

        if ($this->dbType === DBType::INTEGER) {
            if (preg_match('/[A-Z]/', $cleanValue)) {
                throw new \InvalidArgumentException(__('laravel-br-helper::exceptions.cnpj_alpha_in_dbtype_integer'));
            }
            return (int) $cleanValue;
        }

        return match ($this->dbType) {
            DBType::FORMATTED => SM::make($cleanValue)->maskBrCnpj()->getString(),
            // DBType::STRING is default
            default => $cleanValue,
        };
    }
}

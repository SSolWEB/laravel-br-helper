<?php

namespace SSolWEB\LaravelBrHelper\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Enums\DataType;
use SSolWEB\StringMorpher\StringMorpher as SM;

class CpfCast implements CastsAttributes
{
    private DataType $saveAs;

    /**
     * Construct  a instance
     * @param DataType|string $saveAs Use an option to configure.
     */
    public function __construct(DataType|string $saveAs = DataType::STRING)
    {
        $this->saveAs = is_string($saveAs) ? DataType::from($saveAs) : $saveAs;
    }

    /**
     * Construct a personalized cast parameter
     * @see https://laravel.com/docs/12.x/eloquent-mutators#cast-parameters.
     * @param DataType|string $saveAs Use an option to configure.
     * @return string
     */
    public static function saveAs(DataType|string $saveAs)
    {
        return static::class . ':' . $saveAs->value;
    }

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
        $smValue = match ($this->saveAs) {
            DataType::INTEGER => SM::onlyNumbers($value)->padL(11, '0'),
            DataType::FORMATTED => SM::onlyNumbers($value),
            // DataType::STRING is default
            default => SM::make($value),
        };
        return $smValue->maskBrCpf()->getString();
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
        return match ($this->saveAs) {
            DataType::INTEGER => (int) SM::onlyNumbers($value)->getString(),
            DataType::FORMATTED => SM::onlyNumbers($value)->maskBrCpf($value)->getString(),
            // DataType::STRING is default
            default => SM::onlyNumbers($value)->sub(0, 11)->padL(11, '0')->getString(),
        };
    }
}

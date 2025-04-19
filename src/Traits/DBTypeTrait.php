<?php

namespace SSolWEB\LaravelBrHelper\Traits;

use SSolWEB\LaravelBrHelper\Enums\DBType;

trait DBTypeTrait
{
    private DBType $dbType;

    /**
     * Construct  a instance
     * @param DBType|string $dbType Use an option to configure.
     */
    public function __construct(DBType|string $dbType = DBType::STRING)
    {
        $this->dbType = is_string($dbType) ? DBType::from($dbType) : $dbType;
    }

    /**
     * Construct a personalized cast parameter
     * @see https://laravel.com/docs/12.x/eloquent-mutators#cast-parameters.
     * @param DBType|string $dbType Use an option to configure.
     * @return string
     */
    public static function dbType(DBType|string $dbType)
    {
        return static::class . ':' . $dbType->value;
    }
}

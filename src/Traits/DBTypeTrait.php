<?php

namespace SSolWEB\LaravelBrHelper\Traits;

use SSolWEB\LaravelBrHelper\Enums\DBType;

trait DBTypeTrait
{
    private DBType $dbType;

    /**
     * Construct a instance
     * @param DBType|string|null $dbType Use an option to configure.
     */
    public function __construct(DBType|string|null $dbType = null)
    {
        $this->dbType = $this->parseDbType($dbType);
    }

    /**
     * Parse DBType parameter.
     * @param DBType|string|null $dbType Use an option to configure.
     * @return DBType
     */
    private function parseDbType(DBType|string|null $dbType): DBType
    {
        if ($dbType === null) {
            $configKey = strtolower(str_replace('Cast', '', class_basename(static::class)));
            $dbType = config("laravel-br-helper.casts.{$configKey}") ?? DBType::STRING;
        }

        return is_string($dbType) ? DBType::from($dbType) : $dbType;
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

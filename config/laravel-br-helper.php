<?php

use SSolWEB\LaravelBrHelper\Enums\DBType;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Cast Types
    |--------------------------------------------------------------------------
    |
    | This option controls the default DBType for each cast.
    | Valid options: DBType::STRING->value, DBType::INTEGER->value, DBType::FORMATTED->value
    |
    */
    'casts' => [
        'cpf' => DBType::STRING->value,
        'cnpj' => DBType::STRING->value,
        'cep' => DBType::STRING->value,
        'telefone' => DBType::STRING->value,
    ],
];

<?php

namespace SSolWEB\LaravelBrFormatter\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrFormatter\Casts\CepCast;
use SSolWEB\LaravelBrFormatter\Casts\CnpjCast;
use SSolWEB\LaravelBrFormatter\Casts\CpfCast;
use SSolWEB\LaravelBrFormatter\Casts\TelefoneCast;

class TestModel extends Model
{
    protected $fillable = [
        'cep',
        'cnpj',
        'cpf',
        'telefone',
    ];
    protected function casts(): array
    {
        return [
            'cep' => CepCast::class,
            'cnpj' => CnpjCast::class,
            'cpf' => CpfCast::class,
            'telefone' => TelefoneCast::class,
        ];
    }
};
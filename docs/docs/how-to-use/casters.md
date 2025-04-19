---
title: Casters
parent: "How to use"
nav_order: 2
---

# Data useful manipulation with laravel casters
{: .no_toc }
For all casters, when you the default option (e.g.`CepCast::class`) the DBType::STRING is used.

1. TOC
{:toc}

## CepCast
Cast data to a Brazilian zip code format

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CepCast;

class MyModel extends Model
{
    protected function casts(): array
    {
        return ['cep' => CepCast::class];
    }
}
```

You can cast the values to the your database format:

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CepCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // in DB: '44555666', when using $model->cep1: '44.555-666'
            'cep1' => CepCast::dbType(DBType::STRING),
            // in DB: 4555666, when using $model->cep2: '04.555-666'
            'cep2' => CepCast::dbType(DBType::INTEGER),
            // in DB: '44.555-666', when using $model->cep3: '44.555-666'
            'cep3' => CepCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

## CnpjCast
Cast data to a Brazilian bussiness id format

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CnpjCast;

class MyModel extends Model
{
    protected function casts(): array
    {
        return ['cnpj' => CnpjCast::class];
    }
}
```

You can cast the values to the your database format:

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CnpjCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // in DB: '11222333000144', when using $model->cnpj1: '11.222.333/0001-44'
            'cnpj1' => CnpjCast::dbType(DBType::STRING),
            // in DB: 1222333000144, when using $model->cnpj2: '01.222.333/0001-44'
            'cnpj2' => CnpjCast::dbType(DBType::INTEGER),
            // in DB: '11.222.333/0001-44', when using $model->cnpj3: '11.222.333/0001-44'
            'cnpj3' => CnpjCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

## CpfCast
Cast data to a Brazilian person id format

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CpfCast;

class MyModel extends Model
{
    protected function casts(): array
    {
        return ['cpf' => CpfCast::class];
    }
}
```

You can cast the values to the your database format:

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CpfCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // in DB: '12345678909', when using $model->cpf1: '123.456.789-09'
            'cpf1' => CpfCast::dbType(DBType::STRING),
            // in DB: 2345678909, when using $model->cpf2: '023.456.789-09'
            'cpf2' => CpfCast::dbType(DBType::INTEGER),
            // in DB: '123.456.789-09', when using $model->cpf3: '123.456.789-09'
            'cpf3' => CpfCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

## TelefoneCast
Cast data to a Brazilian phone format

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\TelefoneCast;

class MyModel extends Model
{
    protected function casts(): array
    {
        return ['telefone' => TelefoneCast::class];
    }
}
```

You can cast the values to the your database format:

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\TelefoneCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // in DB: '11999994444', when using $model->telefone1: '(11) 99999-4444'
            'telefone1' => TelefoneCast::dbType(DBType::STRING),
            // in DB: 11999994444, when using $model->telefone2: '(11) 99999-4444'
            'telefone2' => TelefoneCast::dbType(DBType::INTEGER),
            // in DB: '(11) 99999-4444', when using $model->telefone3: '(11) 99999-4444'
            'telefone3' => TelefoneCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

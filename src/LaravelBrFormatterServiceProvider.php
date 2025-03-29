<?php
namespace SSolWEB\LaravelBrFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use SSolWEB\LaravelBrFormatter\Casts\CepCast;
use SSolWEB\LaravelBrFormatter\Casts\CnpjCast;
use SSolWEB\LaravelBrFormatter\Casts\CpfCast;
use SSolWEB\LaravelBrFormatter\Casts\TelefoneCast;

class LaravelBrFormatterServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
    }
}

<?php

namespace SSolWEB\LaravelBrHelper\Tests\Traits;

use SSolWEB\LaravelBrHelper\LaravelBrHelperServiceProvider;

trait GetPackageProvider
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelBrHelperServiceProvider::class,
        ];
    }
}

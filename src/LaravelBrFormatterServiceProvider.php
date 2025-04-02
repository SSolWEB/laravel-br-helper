<?php

namespace SSolWEB\LaravelBrHelper;

use Illuminate\Support\ServiceProvider;

class LaravelBrHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services and bindings in the Laravel dependency injection container.
     * This method is called before all other service providers are initialized
     * ensuring that the bindings and configurations are available to the rest of the application.
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-br-helper.php', 'laravel-br-helper');
    }

    /**
     * Boot.
     * Inicialization and interaction with other services.
     * @return void
     */
    public function boot()
    {
        // php artisan vendor:publish --tag=laravel-br-helper
        $paths = [
            __DIR__.'/../config/laravel-br-helper.php' => config_path('laravel-br-helper.php'),
        ];
        $this->publishes($paths, 'laravel-br-helper');
    }
}

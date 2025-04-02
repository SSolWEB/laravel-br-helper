<?php

namespace SSolWEB\LaravelBrHelper\Tests\ServiceProvider;

use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Tests\Traits\GetPackageProvider;

class LaravelBrHelperServiceProviderTest extends TestCase
{
    use GetPackageProvider;

    public function testConfigFileIsPublishable()
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'laravel-br-helper'
        ])->assertExitCode(0);
        $this->assertFileExists(config_path('laravel-br-helper.php'));
        //Check if content matches
        $publishedConfig = file_get_contents(config_path('laravel-br-helper.php'));
        $originalConfig = file_get_contents(__DIR__ . '/../../config/laravel-br-helper.php');
        $this->assertEquals($originalConfig, $publishedConfig);
    }
}

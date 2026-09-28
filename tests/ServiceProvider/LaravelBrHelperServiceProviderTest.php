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

    public function testLangFilesArePublishable()
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'laravel-br-helper'
        ])->assertExitCode(0);

        $this->assertDirectoryExists($this->app->langPath('vendor/laravel-br-helper'));

        $this->assertFileExists($this->app->langPath('vendor/laravel-br-helper/pt_BR/exceptions.php'));
        $this->assertFileExists($this->app->langPath('vendor/laravel-br-helper/en/exceptions.php'));

        //Check if content matches
        $publishedPtBr = file_get_contents($this->app->langPath('vendor/laravel-br-helper/pt_BR/exceptions.php'));
        $originalPtBr = file_get_contents(__DIR__ . '/../../lang/pt_BR/exceptions.php');
        $this->assertEquals($originalPtBr, $publishedPtBr);

        $publishedEn = file_get_contents($this->app->langPath('vendor/laravel-br-helper/en/exceptions.php'));
        $originalEn = file_get_contents(__DIR__ . '/../../lang/en/exceptions.php');
        $this->assertEquals($originalEn, $publishedEn);
    }

    public function testTranslationsAreLoaded()
    {
        $this->assertEquals(
            'CNPJ com formato alfanumérico não é suportado pelo DBType::INTEGER.',
            __('laravel-br-helper::exceptions.cnpj_alpha_in_dbtype_integer', [], 'pt_BR')
        );

        $this->assertEquals(
            'Alphanumeric CNPJ format is not supported by DBType::INTEGER.',
            __('laravel-br-helper::exceptions.cnpj_alpha_in_dbtype_integer', [], 'en')
        );
    }
}

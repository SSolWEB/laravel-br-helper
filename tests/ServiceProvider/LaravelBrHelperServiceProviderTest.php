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
            '--tag' => 'laravel-br-helper',
            '--force' => true
        ])->assertExitCode(0);
        $this->assertFileExists(config_path('laravel-br-helper.php'));
        //Check if content matches
        $publishedConfig = file_get_contents(config_path('laravel-br-helper.php'));
        $originalConfig = file_get_contents(__DIR__ . '/../../config/laravel-br-helper.php');
        $this->assertEquals(str_replace("\r", "", $originalConfig), str_replace("\r", "", $publishedConfig));
    }

    public function testLangFilesArePublishable()
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'laravel-br-helper',
            '--force' => true
        ])->assertExitCode(0);

        $this->assertDirectoryExists($this->app->langPath('vendor/laravel-br-helper'));

        $this->assertFileExists($this->app->langPath('vendor/laravel-br-helper/pt_BR/exceptions.php'));
        $this->assertFileExists($this->app->langPath('vendor/laravel-br-helper/en/exceptions.php'));
        $this->assertFileExists($this->app->langPath('vendor/laravel-br-helper/pt_BR/validation.php'));
        $this->assertFileExists($this->app->langPath('vendor/laravel-br-helper/en/validation.php'));

        //Check if content matches
        $publishedPtBrEx = file_get_contents($this->app->langPath('vendor/laravel-br-helper/pt_BR/exceptions.php'));
        $originalPtBrEx = file_get_contents(__DIR__ . '/../../lang/pt_BR/exceptions.php');
        $this->assertEquals(str_replace("\r", "", $originalPtBrEx), str_replace("\r", "", $publishedPtBrEx));

        $publishedEnEx = file_get_contents($this->app->langPath('vendor/laravel-br-helper/en/exceptions.php'));
        $originalEnEx = file_get_contents(__DIR__ . '/../../lang/en/exceptions.php');
        $this->assertEquals(str_replace("\r", "", $originalEnEx), str_replace("\r", "", $publishedEnEx));

        $publishedPtBrVal = file_get_contents($this->app->langPath('vendor/laravel-br-helper/pt_BR/validation.php'));
        $originalPtBrVal = file_get_contents(__DIR__ . '/../../lang/pt_BR/validation.php');
        $this->assertEquals(str_replace("\r", "", $originalPtBrVal), str_replace("\r", "", $publishedPtBrVal));

        $publishedEnVal = file_get_contents($this->app->langPath('vendor/laravel-br-helper/en/validation.php'));
        $originalEnVal = file_get_contents(__DIR__ . '/../../lang/en/validation.php');
        $this->assertEquals(str_replace("\r", "", $originalEnVal), str_replace("\r", "", $publishedEnVal));
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

        $this->assertEquals(
            'O CPF informado é inválido.',
            __('laravel-br-helper::validation.cpf', [], 'pt_BR')
        );

        $this->assertEquals(
            'The provided CPF is invalid.',
            __('laravel-br-helper::validation.cpf', [], 'en')
        );
    }
}

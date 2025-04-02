<?php

namespace SSolWEB\LaravelBrHelper\Tests\Rules;

use Illuminate\Support\Facades\Validator;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Rules\CpfRule;
use SSolWEB\LaravelBrHelper\Tests\Traits\GetPackageProvider;

class CpfRuleTest extends TestCase
{
    use GetPackageProvider;

    public function testValidMaskedCpf()
    {
        $validator = Validator::make(
            ['cpf' => '529.982.247-25'],
            ['cpf' => ['required', new CpfRule()]]
        );
        $this->assertTrue($validator->passes());
    }

    public function testValidUnmaskedCpf()
    {
        $validator = Validator::make(
            ['cpf' => '52998224725'],
            ['cpf' => ['required', new CpfRule()]]
        );
        $this->assertTrue($validator->passes());
    }

    public function testInvalidMaskedCpf()
    {
        $validator = Validator::make(
            ['cpf' => '111.111.111-11'],
            ['cpf' => ['required', new CpfRule()]]
        );
        $this->assertTrue($validator->fails());
        $this->assertEquals(config('laravel-br-helper.validation.cpf'), $validator->messages()->first('cpf'));
    }

    public function testInvalidUnmaskedCpf()
    {
        $validator = Validator::make(
            ['cpf' => '11111111111'],
            ['cpf' => ['required', new CpfRule()]]
        );
        $this->assertTrue($validator->fails());
        $this->assertEquals(config('laravel-br-helper.validation.cpf'), $validator->messages()->first('cpf'));
    }
}

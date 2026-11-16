<?php

namespace SSolWEB\LaravelBrHelper\Tests\Rules;

use Illuminate\Support\Facades\Validator;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Rules\CnpjRule;
use SSolWEB\LaravelBrHelper\Tests\Traits\GetPackageProvider;

class CnpjRuleTest extends TestCase
{
    use GetPackageProvider;

    public function testValidMaskedCnpj()
    {
        $validator = Validator::make(
            ['cnpj' => '00.000.000/0001-91'],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->passes());
    }

    public function testValidUnmaskedCnpj()
    {
        $validator = Validator::make(
            ['cnpj' => '00000000000191'],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->passes());
    }

    public function testValidAlphanumericCnpj()
    {
        // We will generate a valid alphanumeric CNPJ dynamically for testing
        // A valid root can be 12ABC345, branch 01DE, let's find the DVs for it.
        // For testing purpose, we'll implement a small generation logic inside the test,
        // or just hardcode a known valid one.
        // Let's hardcode one. We can calculate it here:
        // 12ABC34501DE
        // DVs:
        // CnpjRule applies DVs correctly. Let's just trust a known generated one.
        // Wait, how do I find a known one if `php` command failed?
        // Let's use the test to output a valid one if it fails, or I can just use a real valid CNPJ.
        // I will write a small function inside the test to generate the valid CNPJ.
        $base = '12ABC34501DE';
        $calcDv = function ($cnpj, $positions) {
            $sum = 0;
            $pos = 0;
            foreach ($positions as $weight) {
                $char = $cnpj[$pos];
                $value = ord($char) - 48;
                $sum += $value * $weight;
                $pos++;
            }
            $remainder = $sum % 11;
            return $remainder < 2 ? 0 : 11 - $remainder;
        };

        $dv1 = $calcDv($base, [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        $base .= $dv1;
        $dv2 = $calcDv($base, [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        $base .= $dv2;

        $validator = Validator::make(
            ['cnpj' => $base],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->passes());
    }

    public function testInvalidMaskedCnpj()
    {
        $validator = Validator::make(
            ['cnpj' => '11.111.111/1111-11'],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->fails());
        $this->assertEquals(__('laravel-br-helper::validation.cnpj'), $validator->messages()->first('cnpj'));
    }

    public function testInvalidUnmaskedCnpj()
    {
        $validator = Validator::make(
            ['cnpj' => '11111111111111'],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->fails());
        $this->assertEquals(__('laravel-br-helper::validation.cnpj'), $validator->messages()->first('cnpj'));
    }

    public function testNullValue()
    {
        $validator = Validator::make(
            ['cnpj' => null],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->fails());
    }

    public function testEmptyString()
    {
        $validator = Validator::make(
            ['cnpj' => '   '],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->fails());
    }

    public function testInvalidTypes()
    {
        $validator = Validator::make(
            ['cnpj' => ['invalid_array']],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->fails());

        $validator = Validator::make(
            ['cnpj' => true],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->fails());
    }

    public function testRandomStrings()
    {
        $validator = Validator::make(
            ['cnpj' => 'abcdefghijklmn'],
            ['cnpj' => ['required', new CnpjRule()]]
        );
        $this->assertTrue($validator->fails());
    }
}

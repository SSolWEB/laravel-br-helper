<?php

namespace SSolWEB\LaravelBrHelper\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string $attribute Attribute name.
     * @param mixed $value Attribute value.
     * @param \Closure $fail Closure to fail validation.
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isCpfValid($value)) {
            $fail(config('laravel-br-helper.validation.cpf'));
        }
    }

    /**
     * https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
     * @author rafael neri
     * @param string|integer $CPF Cpf to be validated.
     * @return boolean
     */
    private function isCpfValid(string|int $CPF)
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $CPF);
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}

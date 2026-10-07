<?php

namespace SSolWEB\LaravelBrHelper\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Brazilian CNPJ validation rule.
 */
class CnpjRule implements ValidationRule
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
        if (empty($value) || (!is_string($value) && !is_int($value))) {
            $fail(__('laravel-br-helper::validation.cnpj'));
            return;
        }

        if (!$this->isCnpjValid((string) $value)) {
            $fail(__('laravel-br-helper::validation.cnpj'));
        }
    }

    /**
     * @param string $CNPJ Cnpj to be validated.
     * @return boolean
     */
    private function isCnpjValid(string $CNPJ)
    {
        $cnpj = preg_replace('/[^a-zA-Z0-9]/', '', $CNPJ);
        $cnpj = strtoupper($cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/^([a-zA-Z0-9])\1{13}$/', $cnpj)) {
            return false;
        }

        $dv1 = $this->calcDv($cnpj, [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        $dv2 = $this->calcDv($cnpj, [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);

        return $cnpj[12] == $dv1 && $cnpj[13] == $dv2;
    }

    /**
     * @param string $cnpj Cnpj to be validated.
     * @param array $positions Positions to be multiplied.
     * @return int
     */
    private function calcDv (string $cnpj, array $positions) {
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
    }
}

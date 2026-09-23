---
title: "CpfRule"
parent: Rules
nav_order: 1
---

## CpfRule
A `CpfRule` é uma regra de validação customizada para o Laravel focada em validar o número do Cadastro de Pessoas Físicas (CPF). Ela aplica a verificação correta dos dígitos verificadores.

### Parâmetros e Opções
Nenhum parâmetro extra é exigido para inicialização padrão.

### Exemplo de Uso

**Uso no Validator Facade:**
```php
use Illuminate\Support\Facades\Validator;
use SSolWEB\LaravelBrHelper\Rules\CpfRule;

$validator = Validator::make(
    ['cpf' => '529.982.247-25'],
    ['cpf' => ['required', new CpfRule()]]
);
```

**Uso em Form Requests:**
```php
use Illuminate\Foundation\Http\FormRequest;
use SSolWEB\LaravelBrHelper\Rules\CpfRule;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cpf' => ['required', new CpfRule()],
        ];
    }
}
```

### Resultados Esperados
- **Sucesso:** A validação irá passar caso o CPF possua um formato válido e seus dígitos verificadores estejam matematicamente corretos.
- **Falhas e Limitações:**
  - Valores nulos ou não enviados devem ser validados antecipadamente em conjunto com outras regras de validação base como `required` ou `nullable`. A regra em si focará em falhar caso o CPF tenha dígitos verificadores incorretos.
  - Caso receba strings vazias ou tamanhos que não se encaixam nas regras de um CPF, a validação retornará erro e uma mensagem apropriada do Laravel.

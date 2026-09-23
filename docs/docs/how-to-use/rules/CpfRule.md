---
title: "CpfRule"
parent: Rules
nav_order:
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
- **Sucesso:** A validação irá passar caso o CPF possua exatamente 11 dígitos (após a remoção de qualquer máscara/formatação), não seja uma sequência de números repetidos (ex: `111.111.111-11`) e seus dígitos verificadores estejam matematicamente corretos.
- **Valores Vazios ou Tipos Inválidos:** Caso o valor informado seja vazio (`""`), `null`, ou de um tipo não suportado (como `array` ou `boolean`), a regra falhará a validação de forma segura.

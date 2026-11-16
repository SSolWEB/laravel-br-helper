---
title: "CnpjRule"
parent: Rules
nav_order:
---

## CnpjRule
A `CnpjRule` é uma regra de validação customizada para o Laravel focada em validar o número do Cadastro Nacional da Pessoa Jurídica (CNPJ). Ela aplica a verificação correta dos dígitos verificadores, suportando tanto o formato numérico tradicional quanto o novo formato alfanumérico.

### Parâmetros e Opções
Nenhum parâmetro extra é exigido para inicialização padrão.

### Exemplo de Uso

**Uso no Validator Facade:**
```php
use Illuminate\Support\Facades\Validator;
use SSolWEB\LaravelBrHelper\Rules\CnpjRule;

$validator = Validator::make(
    ['cnpj' => '00.000.000/0001-91'],
    ['cnpj' => ['required', new CnpjRule()]]
);
```

**Uso em Form Requests:**
```php
use Illuminate\Foundation\Http\FormRequest;
use SSolWEB\LaravelBrHelper\Rules\CnpjRule;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cnpj' => ['required', new CnpjRule()],
        ];
    }
}
```

### Resultados Esperados
- **Sucesso:** A validação irá passar caso o CNPJ possua exatamente 14 caracteres (após a remoção de qualquer máscara/formatação), não seja uma sequência de números ou letras repetidas, e seus dígitos verificadores estejam matematicamente corretos através do Módulo 11.
- **Formato Alfanumérico:** A regra já está preparada para validar os novos formatos de CNPJ alfanumérico.
- **Valores Vazios ou Tipos Inválidos:** Caso o valor informado seja vazio (`""`), `null`, ou de um tipo não suportado (como `array` ou `boolean`), a regra falhará a validação de forma segura.

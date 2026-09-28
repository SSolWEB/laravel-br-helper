---
title: "TelefoneCast"
parent: Casters
nav_order:
---

## TelefoneCast
O `TelefoneCast` transforma dados de telefones brasileiros, aplicando a formatação de máscaras de celular (9 dígitos) ou fixo (8 dígitos) com DDD.

### Parâmetros e Opções
Este Cast aceita a configuração do comportamento de armazenamento via `DBType`. Consulte a [página principal de Casters](/laravel-br-helper/docs/how-to-use/casters/) para entender como configurar o formato de armazenamento padrão globalmente via `config` ou localmente por atributo.

### Exemplo de Uso

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\TelefoneCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // No banco: '11999994444', na leitura ($model->telefone1): '(11) 99999-4444'
            'telefone1' => TelefoneCast::dbType(DBType::STRING),
            
            // No banco: 11999994444, na leitura ($model->telefone2): '(11) 99999-4444'
            'telefone2' => TelefoneCast::dbType(DBType::INTEGER),
            
            // No banco: '(11) 99999-4444', na leitura ($model->telefone3): '(11) 99999-4444'
            'telefone3' => TelefoneCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

### Resultados Esperados
- **Sucesso:**
  - Valores com 10 dígitos (fixo) resultam na leitura do modelo em `(XX) XXXX-XXXX`.
  - Valores com 11 dígitos (celular) resultam na leitura do modelo em `(XX) XXXXX-XXXX`.
  - A escrita no banco segue as regras do `DBType` escolhido.

- **Limitações e Comportamentos Específicos:**
  - Caso o valor informado seja `null`, vazio (`""`) ou de um tipo inválido (como `array` ou `boolean`), o cast retornará e salvará `null`.
  - **Truncamento:** A classe extrai apenas os números e **trunca o valor para no máximo 11 dígitos** antes de salvar no banco de dados. Para `DBType::INTEGER`, o cast nativo do PHP para `int` também removerá **zeros à esquerda**.
  - Entradas que não atinjam 10 ou 11 dígitos numéricos (após a remoção de caracteres não numéricos) não ativarão a máscara completa e retornarão sem a formatação esperada para telefones.

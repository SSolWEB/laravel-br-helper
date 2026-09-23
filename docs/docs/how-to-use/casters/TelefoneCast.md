---
title: "TelefoneCast"
parent: Casters
nav_order:
---

## TelefoneCast
O `TelefoneCast` transforma dados de telefones brasileiros, aplicando a formatação de máscaras de celular (9 dígitos) ou fixo (8 dígitos) com DDD.

### Parâmetros e Opções
Por padrão, ao utilizar sem parâmetros extras (ex: `TelefoneCast::class`), a opção `DBType::STRING` é definida internamente. Modifique o armazenamento no banco de dados usando o enum `DBType`:
- `DBType::STRING`: Armazena apenas os números do telefone como string.
- `DBType::INTEGER`: Armazena apenas os números em formato numérico (inteiro).
- `DBType::FORMATTED`: Armazena o telefone já formatado com a pontuação no banco de dados.

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

- **imitações e Comportamentos Específicos:**
  - Valores `null` são retornados como `null` tanto na leitura (get) quanto na escrita (set).
  - Strings vazias ou valores sem nenhum número: resultam em uma string vazia `""` ao salvar com `DBType::STRING` ou `DBType::FORMATTED`, e resultam no inteiro `0` ao salvar com `DBType::INTEGER`.
  - **Truncamento:** Para `DBType::STRING` e `DBType::FORMATTED`, a classe extrai apenas os números e **trunca o valor para no máximo 11 dígitos** antes de salvar no banco de dados. 
  - Para `DBType::INTEGER`, o valor numérico **não é truncado** para 11 dígitos, porém o cast nativo do PHP para `int` remove **zeros à esquerda**.
  - Entradas que não atinjam 10 ou 11 dígitos (após a remoção de caracteres não numéricos) não ativarão a máscara completa e retornarão sem a formatação esperada para telefones.

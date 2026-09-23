---
title: "CnpjCast"
parent: Casters
nav_order: 2
---

## CnpjCast
O `CnpjCast` transforma dados de CNPJ (Cadastro Nacional da Pessoa Jurídica).

### Parâmetros e Opções
Por padrão, se não especificado (ex: `CnpjCast::class`), a opção `DBType::STRING` é utilizada. É possível definir o formato do dado salvo no banco através do Enum `DBType`:
- `DBType::STRING`: Armazena apenas os números em formato string.
- `DBType::INTEGER`: Armazena apenas os números em formato inteiro.
- `DBType::FORMATTED`: Armazena o CNPJ formatado no banco de dados.

### Exemplo de Uso

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CnpjCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // No banco: '11222333000144', na leitura ($model->cnpj1): '11.222.333/0001-44'
            'cnpj1' => CnpjCast::dbType(DBType::STRING),
            
            // No banco: 1222333000144, na leitura ($model->cnpj2): '01.222.333/0001-44'
            'cnpj2' => CnpjCast::dbType(DBType::INTEGER),
            
            // No banco: '11.222.333/0001-44', na leitura ($model->cnpj3): '11.222.333/0001-44'
            'cnpj3' => CnpjCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

### Resultados Esperados
- **Sucesso:**
  - Valores limpos ou desformatados são convertidos na saída para o formato visual `XX.XXX.XXX/XXXX-XX`.
  - A conversão de volta para o banco obedecerá o `DBType` configurado.
- **Tratamento de Valores Especiais e Limitações:**
  - Para `null` será retornado e salvo `null`.
  - Entradas vazias ou com menos de 14 dígitos (após a extração de números) receberão preenchimento de zeros à esquerda (`padL`) para atingir 14 dígitos.
    - Com `DBType::STRING`: O valor será salvo no banco como uma string de 14 dígitos preenchida com zeros à esquerda (ex: `'123'` vira `'00000000000123'`, vazio vira `'00000000000000'`). Excedentes acima de 14 dígitos são truncados.
    - Com `DBType::INTEGER`: O valor será salvo como número inteiro. Ao recuperar os dados (`get`), os zeros à esquerda necessários para atingir 14 dígitos serão restaurados.
    - Com `DBType::FORMATTED`: O valor será salvo já formatado com a máscara e preenchido com zeros (ex: `'123'` vira `'00.000.000/0001-23'`, vazio vira `'00.000.000/0000-00'`). Excedentes acima de 14 dígitos são truncados.

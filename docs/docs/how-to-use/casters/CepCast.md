---
title: "CepCast"
parent: Casters
nav_order:
---

## CepCast
O `CepCast` transforma dados de CEP (Código de Endereçamento Postal) brasileiro.

### Parâmetros e Opções
Por padrão, caso não especificado (ex: `CepCast::class`), a opção `DBType::STRING` é utilizada. Você pode especificar o tipo que será armazenado no banco de dados utilizando os seguintes enums de `DBType`:
- `DBType::STRING`: Armazena os números no banco de dados, sempre em formato de string com exatamente 8 dígitos (preenchido com zeros à esquerda caso menor, e truncado caso maior).
- `DBType::INTEGER`: Armazena os números no banco de dados em formato numérico (inteiro). Zeros à esquerda são naturalmente perdidos na gravação, mas recuperados na leitura.
- `DBType::FORMATTED`: Extrai até 8 números e armazena a string já formatada com a pontuação no banco de dados.

### Exemplo de Uso

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CepCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // No banco: '44555666', na leitura ($model->cep1): '44.555-666'
            'cep1' => CepCast::dbType(DBType::STRING),
            
            // No banco: 4555666, na leitura ($model->cep2): '04.555-666'
            'cep2' => CepCast::dbType(DBType::INTEGER),
            
            // No banco: '44.555-666', na leitura ($model->cep3): '44.555-666'
            'cep3' => CepCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

### Resultados Esperados
- **Sucesso:**
  - Valores numéricos válidos serão convertidos e formatados na saída para o formato `XX.XXX-XXX`.
  - A conversão de volta para o banco dependerá do `DBType` configurado.
- **Limitações:**
  - Caso o valor informado seja `null`, o cast retornará `null`.
  - Não há fallback para retornar a string original em caso de entrada inválida, vazia ou menor que 8 dígitos. A entrada será sempre higienizada (mantendo apenas números). Strings vazias ou inválidas resultarão em `'00000000'` (no caso de `DBType::STRING`), `0` (no caso de `DBType::INTEGER`), ou em uma string formatada equivalente a vazio ou parcialmente mascarada (no caso de `DBType::FORMATTED`). Entradas com mais de 8 dígitos numéricos serão truncadas (cortadas após o oitavo dígito).

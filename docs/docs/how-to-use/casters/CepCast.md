---
title: "CepCast"
parent: Casters
nav_order: 1
---

## CepCast
O `CepCast` transforma dados de CEP (Código de Endereçamento Postal) brasileiro.

### Parâmetros e Opções
Por padrão, caso não especificado (ex: `CepCast::class`), a opção `DBType::STRING` é utilizada. Você pode especificar o tipo que será armazenado no banco de dados utilizando os seguintes enums de `DBType`:
- `DBType::STRING`: Armazena apenas os números no banco de dados, em formato de string.
- `DBType::INTEGER`: Armazena apenas os números no banco de dados, em formato numérico (inteiro).
- `DBType::FORMATTED`: Armazena a string já formatada com a pontuação no banco de dados.

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
  - A conversão de volta para o banco dependerá do `DBType` configurado (somente números como string, números como inteiro ou formatado).
- **Falhas e Limitações:**
  - Caso o valor informado seja `null`, o cast deverá retornar `null`.
  - Se a entrada for vazia ou não estiver em um formato numérico válido de 8 dígitos após a limpeza, o comportamento de fallback é retornar a string original ou o valor nulo/limpo conforme a consistência dos dados, sem lançar exceções inesperadas.

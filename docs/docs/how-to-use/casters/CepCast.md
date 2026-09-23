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
- **Limitações e Tratamentos de Borda:**
  - Caso o valor informado seja `null`, vazio (`""`) ou de um tipo inválido (como `array` ou `boolean`), o cast retornará e salvará `null`.
  - Entradas menores que 8 dígitos numéricos receberão preenchimento de zeros à esquerda (`padL`) para atingir 8 dígitos antes de serem formatadas ou salvas.
  - Entradas com mais de 8 dígitos numéricos serão truncadas (cortadas após o oitavo dígito).

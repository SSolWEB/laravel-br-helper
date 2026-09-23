---
title: "CpfCast"
parent: Casters
nav_order: 3
---

## CpfCast
O `CpfCast` transforma dados de CPF (Cadastro de Pessoas Físicas).

### Parâmetros e Opções
Por padrão, caso não especificado (ex: `CpfCast::class`), a opção `DBType::STRING` é utilizada. Você pode especificar o tipo que será armazenado no banco de dados utilizando os enums de `DBType`:
- `DBType::STRING`: Armazena os números no banco de dados, em formato de string.
- `DBType::INTEGER`: Armazena os números no banco de dados, em formato numérico (inteiro).
- `DBType::FORMATTED`: Armazena a string já formatada com a pontuação no banco de dados.

### Exemplo de Uso

```php
use Illuminate\Database\Eloquent\Model;
use SSolWEB\LaravelBrHelper\Casts\CpfCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class MyModel extends Model
{
    protected function casts(): array
    {
        return [
            // No banco: '12345678909', na leitura ($model->cpf1): '123.456.789-09'
            'cpf1' => CpfCast::dbType(DBType::STRING),
            
            // No banco: 2345678909, na leitura ($model->cpf2): '023.456.789-09'
            'cpf2' => CpfCast::dbType(DBType::INTEGER),
            
            // No banco: '123.456.789-09', na leitura ($model->cpf3): '123.456.789-09'
            'cpf3' => CpfCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

### Resultados Esperados
- **Sucesso:**
  - Valores limpos na entrada serão exibidos e retornados na instância do Eloquent no formato `XXX.XXX.XXX-XX`.
  - A conversão de volta para o banco dependerá do `DBType` configurado.
- **Falhas e Limitações:**
  - Caso o valor seja `null`, o sistema retornará `null`.
  - Entradas vazias ou não numéricas incompletas, que após limpas não atinjam 11 dígitos, não poderão ser perfeitamente formatadas. Nesses casos, a string ou o valor original sem alteração de formatação é preservado no fallback.

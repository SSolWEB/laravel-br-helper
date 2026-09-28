---
title: Casters
parent: "How to use"
has_children: true
nav_order:
---

# Manipulação de Dados (Casters)
{: .no_toc }

A biblioteca `laravel-br-helper` provê Casters customizados para formatar de forma elegante os dados brasileiros ao utilizá-los no Eloquent. 

## Como os dados são salvos no banco de dados (DBType)

Na maioria dos Casters fornecidos pela biblioteca, você tem a liberdade de decidir como o dado será fisicamente armazenado no banco de dados utilizando o enumerador `DBType`. Independentemente do que você escolher aqui, **a leitura na sua Model (get) sempre retornará o valor formatado e padronizado**.

Os tipos disponíveis são:
- `DBType::STRING`: Armazena os números no banco de dados em formato de string **sem formatação**.
- `DBType::INTEGER`: Armazena os números no banco de dados em formato numérico (inteiro). Útil se o seu banco exige tipos estritos, porém não é suportado caso o dado possua letras (ex: CNPJ alfanumérico).
- `DBType::FORMATTED`: Armazena a string já formatada com pontuações e máscaras no banco de dados.

### Configurando Globalmente

Por padrão, todos os Casters salvam no formato `DBType::STRING`. Você pode alterar esse comportamento **para toda a aplicação** no arquivo de configuração `config/laravel-br-helper.php` (publicado na etapa de [instalação](/laravel-br-helper/docs/installation/)):

```php
use SSolWEB\LaravelBrHelper\Enums\DBType;

'casts' => [
    'cpf' => DBType::STRING->value,
    'cnpj' => DBType::STRING->value,
    'cep' => DBType::STRING->value,
    'telefone' => DBType::STRING->value,
],
```

### Configurando Localmente (Por Atributo)

Se desejar sobrescrever o comportamento global em uma Model específica, basta repassar o parâmetro no array de `$casts`:

```php
use \SSolWEB\LaravelBrHelper\Casts\CpfCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

protected function casts(): array
{
    return [
        'cpf_apenas_numeros' => CpfCast::class, // Usa o default do config
        'cpf_formatado' => CpfCast::dbType(DBType::FORMATTED), // específico
    ];
}
```

---

Acesse as páginas de cada caster no menu lateral para visualizar detalhes e particularidades de cada tipo.

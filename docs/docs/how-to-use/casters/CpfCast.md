---
title: "CpfCast"
parent: Casters
nav_order:
---

## CpfCast
O `CpfCast` transforma dados de CPF (Cadastro de Pessoas Físicas).

### Parâmetros e Opções
Este Cast aceita a configuração do comportamento de armazenamento via `DBType`. Consulte a [página principal de Casters](/laravel-br-helper/docs/how-to-use/casters/) para entender como configurar o formato de armazenamento padrão globalmente via `config` ou localmente por atributo.

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
- **Tratamento de Valores Especiais e Limitações:**
  - Caso o valor informado seja `null`, vazio (`""`) ou de um tipo inválido (como `array` ou `boolean`), o cast retornará e salvará `null`.
  - Entradas com menos de 11 dígitos (após a remoção de caracteres não numéricos) receberão preenchimento de zeros à esquerda (`padL`) para atingir 11 dígitos antes da formatação ou de serem salvas.
  - Entradas com mais de 11 dígitos numéricos serão truncadas (cortadas após o décimo primeiro dígito).

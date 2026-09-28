---
title: "CepCast"
parent: Casters
nav_order:
---

## CepCast
O `CepCast` transforma dados de CEP (Código de Endereçamento Postal) brasileiro.

### Parâmetros e Opções
Este Cast aceita a configuração do comportamento de armazenamento via `DBType`. Consulte a [página principal de Casters](/laravel-br-helper/docs/how-to-use/casters/) para entender como configurar o formato de armazenamento padrão globalmente via `config` ou localmente por atributo.

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

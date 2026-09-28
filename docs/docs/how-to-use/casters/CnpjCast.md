---
title: "CnpjCast"
parent: Casters
nav_order:
---

## CnpjCast
O `CnpjCast` transforma dados de CNPJ (Cadastro Nacional da Pessoa Jurídica), incluindo suporte ao novo formato alfanumérico.

### Parâmetros e Opções
Este Cast aceita a configuração do comportamento de armazenamento via `DBType`. Consulte a [página principal de Casters](/laravel-br-helper/docs/how-to-use/casters/) para entender como configurar o formato de armazenamento padrão globalmente via `config` ou localmente por atributo.

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
            // No banco: '12ABC345000100', na leitura ($model->cnpj1): '12.ABC.345/0001-00'
            'cnpj1' => CnpjCast::dbType(DBType::STRING),
            
            // No banco: 1222333000144, na leitura ($model->cnpj2): '01.222.333/0001-44'
            // LANÇA EXCEÇÃO SE O VALOR CONTER LETRAS.
            'cnpj2' => CnpjCast::dbType(DBType::INTEGER),
            
            // No banco: '12.ABC.345/0001-00', na leitura ($model->cnpj3): '12.ABC.345/0001-00'
            'cnpj3' => CnpjCast::dbType(DBType::FORMATTED),
        ];
    }
}
```

### Resultados Esperados
- **Sucesso:**
  - Valores limpos ou desformatados são convertidos na saída para o formato visual `XX.XXX.XXX/XXXX-XX` (seja puramente numérico ou alfanumérico).
  - A conversão de volta para o banco obedecerá o `DBType` configurado.
  - Caracteres alfa serão normalizados para caixa alta (uppercase).
- **Tratamento de Valores Especiais e Limitações:**
  - Caso o valor informado seja `null`, vazio (`""`) ou de um tipo inválido (como `array` ou `boolean`), o cast retornará e salvará `null`.
  - Entradas com menos de 14 caracteres (após a extração de alfanuméricos) receberão preenchimento de zeros à esquerda (`padL`) para atingir 14 dígitos.
    - Com `DBType::STRING`: O valor será salvo no banco como uma string de 14 caracteres preenchida com zeros à esquerda. Excedentes acima de 14 caracteres são truncados.
    - Com `DBType::INTEGER`: Lança `InvalidArgumentException` se conter letras. Valores apenas numéricos são salvos como inteiro. Ao recuperar os dados (`get`), os zeros à esquerda necessários para atingir 14 dígitos serão restaurados.
    - Com `DBType::FORMATTED`: O valor será salvo já formatado com a máscara e preenchido com zeros. Excedentes acima de 14 caracteres são truncados.

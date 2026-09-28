---
title: "CnpjCast"
parent: Casters
nav_order:
---

## CnpjCast
O `CnpjCast` transforma dados de CNPJ (Cadastro Nacional da Pessoa Jurídica), incluindo suporte ao novo formato alfanumérico.

### Parâmetros e Opções
Por padrão, se não especificado (ex: `CnpjCast::class`), a opção `DBType::STRING` é utilizada. É possível definir o formato do dado salvo no banco através do Enum `DBType`:
- `DBType::STRING`: **(default)**. Armazena apenas os caracteres alfanuméricos (letras em caixa alta e números) em formato string.
- `DBType::FORMATTED`: Armazena o CNPJ formatado no banco de dados.
- `DBType::INTEGER`: Armazena apenas números em formato inteiro. **Atenção:** Este tipo não suporta o formato alfanumérico de CNPJ (que contém letras). Se você tentar salvar um CNPJ com letras usando este tipo, uma `InvalidArgumentException` será lançada. Considere alterar o tipo da coluna no banco de dados para `VARCHAR` e utilizar `DBType::STRING`.

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

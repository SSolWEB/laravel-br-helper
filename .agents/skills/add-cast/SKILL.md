---
name: add-cast
description: Instruções de como criar um novo Cast (conversão de dados) para o laravel-br-helper
---

# Skill: Adicionar Cast

## Propósito
Instruir agentes de IA sobre como implementar novos Casts do Eloquent no repositório `laravel-br-helper`.

## Passos para Implementação

### Passo 1: Criar o arquivo do Cast
Crie um novo arquivo PHP dentro do diretório `src/Casts/`. O nome deve refletir o objetivo da conversão (ex: `CpfCast.php`).

### Passo 2: Implementar a interface
A classe deve implementar a interface `Illuminate\Contracts\Database\Eloquent\CastsAttributes`.

### Passo 3: Desenvolver os métodos get e set
- **`get($model, string $key, $value, array $attributes)`**: Deve transformar o valor proveniente do banco de dados (ex: remover máscara e formatar de um jeito legível).
- **`set($model, string $key, $value, array $attributes)`**: Deve preparar o valor a ser gravado no banco de dados (ex: garantir que apenas números sejam salvos).
- Certifique-se de realizar as tratativas para valores nulos ou vazios caso aplicável.

### Passo 4: Criar os Testes
- Crie um arquivo de teste no diretório `tests/Casts/` (ex: `CpfCastTest.php`).
- Assegure-se de testar:
  - O funcionamento correto do método `get` com dados corretos, inválidos e nulos.
  - O funcionamento correto do método `set` com dados já formatados, sem formatação e nulos.

### Passo 5: Atualizar a Documentação
Toda novo Cast deve ser devidamente documentado.
Siga as instruções de [Atualizar Documentação](../update-docs/SKILL.md) para registrar o novo cast na documentação oficial.

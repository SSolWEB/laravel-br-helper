---
name: add-rule
description: Instruções de como criar uma nova Rule (regra de validação) para o laravel-br-helper
---

# Skill: Adicionar Rule

## Propósito
Instruir agentes de IA sobre como implementar novas Rules de validação no repositório `laravel-br-helper`.

## Passos para Implementação

### Passo 1: Criar o arquivo da Rule
Crie um novo arquivo PHP dentro do diretório `src/Rules/`. O nome do arquivo deve descrever a regra de negócio em PascalCase (ex: `ValidaCPF.php`).

### Passo 2: Implementar a validação
- A classe deve implementar a interface `Illuminate\Contracts\Validation\ValidationRule`.
- Implemente o método `validate(string $attribute, mixed $value, Closure $fail): void`.
- Caso a validação falhe, chame o closure de erro passando a mensagem apropriada (em português).

### Passo 3: Criar os Testes
- Crie o arquivo de teste correspondente no diretório `tests/Rules/` (ex: `ValidaCPFTest.php`).
- A cobertura de testes deve incluir:
  - Cenários de sucesso com dados válidos.
  - Cenários de falha com dados inválidos.
  - Comportamento diante de dados imprevistos, como null, strings vazias, booleanos e arrays.

### Passo 4: Atualizar a Documentação
Toda nova Rule deve ser devidamente documentada.
Siga as instruções de [Atualizar Documentação](../update-docs/SKILL.md) para registrar a nova regra na documentação oficial.

---
name: update-docs
description: Instruções de como atualizar a documentação do laravel-br-helper
---

# Skill: Atualizar Documentação

## Propósito
Orientar a inserção e modificação da documentação da biblioteca `laravel-br-helper`.

## Passos para Implementação

### 1. Estrutura da Documentação
A documentação principal se encontra dentro do diretório `docs/docs/how-to-use/`.
- Regras (Rules) e Casts devem ser documentados em seus respectivos guias ou no guia unificado, conforme a estrutura presente na pasta.

### 2. Formatação e Padrão de Conteúdo
Ao adicionar documentação para um novo recurso (Rule ou Cast), utilize a formatação Markdown e certifique-se de incluir:
- **Título claro:** O que o recurso faz.
- **Descrição sucinta.**
- **Exemplo de código:** Mostre como usar no contexto de um projeto Laravel.
- **Comportamento esperado:** Explicar parâmetros e valores de retorno esperados, bem como mensagens de erro quando aplicável.

### 3. Exemplo Prático (Markdown)
```markdown
---
title: "CpfRule"
parent: Rules
nav_order:
---

### NomeDaRule
Valida se o valor informado atende a determinada regra.

### Parâmetros e Opções
Nenhum parâmetro extra é exigido para inicialização padrão.

### Exemplo de Uso
**Uso no Validator:**

\`\`\`php
use SSolWEB\LaravelBrHelper\Rules\NomeDaRule;

$request->validate([
    'campo' => ['required', new NomeDaRule()],
]);
\`\`\`

### Resultados Esperados
- **Sucesso:** A validação irá passar
```

### 4. Build e Teste (Local)
(Se aplicável) Caso haja uma configuração para visualizar a documentação localmente, execute o comando correspondente para testar a sua alteração.

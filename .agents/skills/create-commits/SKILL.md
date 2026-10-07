---
name: create-commits
description: Instruções de como realizar commits separando as alterações por tipo (conventional commits).
---

# Como realizar commits

Ao realizar commits neste repositório, os agentes devem seguir o padrão de **Conventional Commits** (Commits Semânticos) e sempre **separar as alterações** em múltiplos commits baseando-se na natureza (type) dos arquivos adicionados ou modificados.

## Regras de Separação (Type)

Nunca faça um "commit genérico" (`git commit -am ...`) misturando escopos diferentes. Agrupe os arquivos modificados e realize commits separados para cada uma das categorias:

- `docs`: Utilize exclusivamente para alterações na documentação (ex: arquivos markdown, diretório `docs/`).
- `test`: Utilize exclusivamente para testes automatizados (ex: arquivos no diretório `tests/`).
- `feat` ou `fix`: Utilize para alterações no código-fonte principal de produção (ex: diretório `src/`). `feat` para novas funcionalidades e `fix` para correção de bugs.
- `chore` ou `refactor`: Utilize para tarefas de manutenção, organização de código ou atualização de dependências e configurações.

## Formato da Mensagem

As mensagens devem seguir a estrutura do Conventional Commits, podendo incluir corpo e rodapé para maior contexto:

```text
<tipo>(<escopo opcional>): <descrição breve da alteração>

<corpo do commit com explicações mais detalhadas sobre o que foi feito>

<rodapé, por exemplo: Closes #123>
```

*Exemplo de um commit bem estruturado:*
```text
test(rules): adicionar testes unitários para a validação CnpjRule

- Adiciona testes para validação de formatos com máscara e sem máscara.
- Adiciona testes para validação de formatos alfanumérico.
- Adiciona testes para comportamentos excepcionais.

Closes #4
```

## Passo a Passo para o Agente

1. **Analise o que foi alterado:** Execute `git status` e `git diff`.
2. **Divida em grupos:** Identifique quais arquivos pertencem à documentação, aos testes e ao código fonte.
3. **Faça os commits separadamente:**
   - Faça `git add` apenas nos arquivos de um grupo.
   - Faça o commit usando o respectivo type, garantindo que o corpo da mensagem detalhe os pontos importantes e, se aplicável, inclua um rodapé fechando issues.
   - Repita o processo para os grupos restantes até que todas as suas alterações tenham sido comitadas.

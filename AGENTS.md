# AGENTS.md

Este documento define as diretrizes para agentes de inteligência artificial autônomos ou assistentes de IA que contribuam com a biblioteca **laravel-br-helper**.

## Propósito e Escopo
A biblioteca `laravel-br-helper` é um pacote para Laravel com o objetivo de fornecer validações (Rules), formatações e conversões (Casts) voltadas para regras de negócio e formatos brasileiros (ex: CPF, CNPJ, telefone, CEP, etc).

## Diretrizes Gerais para IA
1. **Evite Dependências Externas:** Não adicione novas dependências ao projeto, a menos que seja estritamente necessário e expressamente solicitado.
2. **Priorize a Estabilidade:** Assegure-se de manter a compatibilidade reversa sempre que possível e adote um design de código defensivo.
3. **Siga os Padrões:** Leia e aplique rigorosamente as instruções detalhadas no `CONTRIBUTING.md`.
4. **Idioma:** Todas as mensagens, documentações e comentários gerados ou atualizados devem ser escritos em Português (PT-BR).

## Estrutura do Repositório (Contexto Espacial)
O repositório é organizado da seguinte forma para as principais funcionalidades:
- **`src/Casts/`**: Classes de conversão e mutação de dados para Eloquent (Casts).
- **`src/Rules/`**: Regras de validação do Laravel (Rules).
- **`tests/`**: Testes automatizados usando PHPUnit. Devem espelhar a estrutura de `src/` (ex: `tests/Casts/`, `tests/Rules/`).
- **`docs/docs/how-to-use/`**: Hospeda a documentação principal da biblioteca, que deve ser mantida atualizada com novos recursos.

## Sistema de Skills
Para executar tarefas específicas no repositório, consulte os arquivos de "Skills" localizados em `.agents/skills/`. Eles contêm tutoriais passo a passo específicos:
- Para criar uma nova validação (Rule), consulte `.agents/skills/add-rule/SKILL.md`.
- Para criar um novo cast de Eloquent, consulte `.agents/skills/add-cast/SKILL.md`.
- Para atualizar a documentação, consulte `.agents/skills/update-docs/SKILL.md`.

# Guia de Contribuição

Obrigado por considerar contribuir para o `laravel-br-helper`! Para manter o projeto organizado e consistente, pedimos que siga as diretrizes abaixo.

Como esta é uma biblioteca voltada para o público brasileiro, **todas as issues, pull requests e documentações devem ser escritas em Português (PT-BR)**.

## Padrões de Issues e Pull Requests

- **Issues**: Ao relatar um bug ou sugerir uma nova funcionalidade, utilize os templates disponíveis em `.github/ISSUE_TEMPLATE/`. Preencha todas as informações solicitadas para facilitar a análise.
- **Pull Requests (PRs)**: Todo PR deve ser enviado para a branch `main`. Certifique-se de preencher o template de PR (`.github/pull_request_template.md`), detalhando as mudanças realizadas e referenciando a issue relacionada, se houver.

## Estrutura de Arquivos em `src/`

A organização do código-fonte é fundamental para a manutenibilidade do pacote. Ao adicionar novas funcionalidades, siga a estrutura existente:

- **Casts**: As classes de casting do Eloquent devem ser colocadas em `src/Casts/` (ex.: `CpfCast.php`).
- **Rules**: As regras de validação do Laravel devem ser colocadas em `src/Rules/` (ex.: `CpfRule.php`).
- **Enums**: Enumerações, como opções de formatação, devem estar em `src/Enums/`.

## Registro de Classes e Componentes

A maioria das classes (Casts e Rules) pode ser utilizada diretamente sem configuração adicional. No entanto, se você estiver introduzindo um novo componente que exija carregamento automático ou configurações globais:
- Registre-o no `SSolWEB\LaravelBrHelper\LaravelBrHelperServiceProvider` (se existir e for aplicável).
- Caso adicione novos Traits ou utilitários, documente seu uso claramente.

## Padrão e Posicionamento de Testes (`tests/`)

Garantir a qualidade do código é essencial. Todo novo recurso ou correção de bug **deve** ser acompanhado de testes automatizados.

- **Espelhamento de Estrutura**: A estrutura de pastas em `tests/` deve espelhar a de `src/`. Por exemplo, testes para `src/Casts/CpfCast.php` devem estar em `tests/Casts/CpfCastTest.php`.
- **Cobertura de Cenários**: Não teste apenas o caminho feliz ("happy path"). Seus testes devem cobrir:
  - Entradas inválidas ou tipos inesperados.
  - Valores nulos (`null`).
  - Strings vazias.
  - Comportamento de falhas esperadas.

## Documentação (Jekyll)

Toda nova funcionalidade adicionada (como novos Casts, Rules, etc.) deve ser devidamente documentada em nossa base construída em Jekyll.
- Crie a documentação detalhada correspondente dentro do diretório apropriado (ex.: `docs/docs/how-to-use/casters/` ou `docs/docs/how-to-use/rules/`).
- Para validar a formatação e visualização da sua documentação localmente, navegue até a pasta `docs/` e rode os comandos do Jekyll.

Certifique-se de que a build passa sem erros antes de realizar seu PR.

## Fluxo de Desenvolvimento Local

Para configurar o ambiente de desenvolvimento local e garantir que suas mudanças atendam aos nossos padrões de qualidade, siga estes passos:

1. Instale as dependências:
   ```bash
   composer install
   ```

2. Realize suas alterações no código e crie seus testes.

3. Execute o linter para garantir que o código segue as PSRs e padrões definidos:
   ```bash
   vendor/bin/phpcs
   ```

4. Rode a suíte de testes para confirmar que nada foi quebrado e que seus testes passam:
   ```bash
   vendor/bin/phpunit
   ```

Somente após os testes e a verificação do linter passarem com sucesso, realize o commit das suas alterações e abra o Pull Request.
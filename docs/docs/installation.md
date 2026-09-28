---
title: "Instalação"
nav_order: 2
---

# Instalação

Como realizar a instalação.

## Utilizando o Composer
Para instalar o pacote Laravel Br Helper via Composer, siga os passos abaixo:

1. Certifique-se de ter o Composer instalado. Se ainda não o possui, baixe e instale a partir de getcomposer.org.

2. Em seu terminal, navegue até o diretório do seu projeto.

3. Execute o seguinte comando para adicionar o pacote Laravel Br Helper ao seu projeto:

```bash
composer require ssolweb/laravel-br-helper
```

Isso fará o download da biblioteca e atualizará automaticamente o arquivo `composer.json` do seu projeto com os detalhes do pacote.

## Publicando as Configurações e Idiomas (Opcional)

A biblioteca possui arquivos de configuração e de idiomas (i18n) que podem ser customizados. Para publicar esses arquivos no seu projeto Laravel, execute o comando artisan abaixo:

```bash
php artisan vendor:publish --tag=laravel-br-helper
```

Isso criará o arquivo `config/laravel-br-helper.php` (permitindo configurar os tipos de dados padrão dos casts) e a pasta `lang/vendor/laravel-br-helper/` (para traduzir ou alterar mensagens de validação e erros).
## Uso
Após a instalação, você pode incluir o pacote no seu código e começar a utilizar seus recursos.


Aproveite 😊

Veja [como usar](/laravel-br-helper/docs/how-to-use/)
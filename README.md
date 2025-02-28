# Contabiliza

## Dependências
- **Internachi (modularização):**
    - Instalação: 
    ```
    composer require internachi/modular
    ```
    - Publicar a configuração: php artisan vendor:publish --tag=modular-config
    - Configuração: criar ou copiar o arquivo de configuração ./config/app-modules.php
    - Para publicar a configuração: 
    ```
    php artisan vendor:publish --tag=modular-config
    ```
    - Para criar um módulo: 
    ```
    php artisan make:module my-module
    ```
    - Atualizar o composer: 'composer update modules/my-module'.
    - Configura o módulo: 'php artisan modules:sync'.
    - Comandos: 
        - Cria um controller no módulo
        ```
        php artisan make:controller MyModuleController --module=[module name]
        ```
        - Cria um seed
        ```
        php artisan db:seed --module=[module name]
        ```
    - Veja: https://github.com/InterNACHI/modulars

- **Bibliotecas de API do laravel:**
    - Instalação: php artisan install:api
    - Editar o arquivo ./boostrap.app.php, linha 8 (withRouting) e adicionar o caminho do arquivo de rota "api: __DIR__.'/../routes/api.php'".
    - Para criar um alias para a rota a API, insira no mesmo ponto (método withRouting) a chave "apiPrefix: 'api/v1'". Isso cria também um alias para o nome da rota com o padrão "api.v1".
    - Configuração das rotas da API no arquivo ./routes/api.php

- **Laravel Mix**
    - Instalação via npm: npm install && npm install laravel-mix --save-dev

- **Sanctum**
    - Instalação:
    ```
    composer require laravel/sanctum
    ```
    - Configuração: 
    ```
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    ```
    

- **Argon2**
    - Verificar se o PHP tem suporte: php -m | grep argon2
    - Criar o arquivo de configuração em config/hash.php: return ['driver' => 'argon2id'];

## Configurar as rotas da API
- Instalar o roteamento API: php artisan install:api.
- Criar as rotas para a API no arquivo ./routes/api.php.
- inserir no arquivo ./boostrap/app.php, método "withRouting" o abaixo:
```
api: __DIR__.'/../routes/api.php',
apiPrefix: 'api/v1',
```
## Testes
- O framework de testes instalado é o Pest
- Para configurar os testes, insira no arquivo ./test/Pest.php:
```
pest()->extend(Tests\TestCase::class)->in('app/*/tests/*');
```
- Para rodar testes: 
```
php artisan migrate:reset --env=testing && \
php artisan migrate --env=testing && \
php artisan test --filter AuthTest --env=testing
```
## Logs da aplicação
- Configurar o arquivo ./config/logging.php criando um "channel"
```
'channels' => [
    'database' => [
            'driver' => 'custom',
            'via' => \App\Logging\DatabaseLogger::class,
            'level' => env('LOG_LEVEL', 'debug'),
        ],
    ],
```
- Criar o arquivo informado na chave "via"
- Uso: 
```
Log::channel('database')-><tipo>(<mensagem>,[<context>]);
```

## Instalação do RBAC
- Para instalar o RBAC do Laminas framework:
```
composer require laminas/laminas-permissions-rbac
```

## Requisitos
### Login


### Usuário:
1) Termos:
    - Cliente: usuário que se cadastra na página de cadastro no domínio público.
    - Colaboradores: os demais usuários com perfis para execução de tarefas administrativas.
2) Perfil:
    - Administrador: pessoa que gerencia a manutenção da aplicação.
        - Cadastra o franquiado.
        - Acessa o painel de administrador.
    - Franquiado: pessoa que contrata a aplicação para gerir seus clientes
        - Cadastra os usuários para operacionalização da ferramenta (gerente, consultor, etc..)
    - Gerente: pessoa cadastrada pelo franqueado para gerir os clientes
        - Cadastra o consultor
        - Edita conta de clientes somente para auxílio na recuperação de acesso
        - Acessa o painel do cliente
    - Consultor: qualquer pessoa do franquiado, contador ou auxiliar, que auxilia o cliente na aplicação. 
    - Cliente: pessoa que contrata o escritório/proffisional de contabilidade
    - Colaborador: pessoa cadastrada pelo cliente para auxiliar na sua gestão. 

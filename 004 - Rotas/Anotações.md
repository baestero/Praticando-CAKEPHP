# Rotas

- Para escolher em qual porta cake inicia podemos utilizar o comando
- cake server -p 8000 por exemplo

- Dentro de config temos o arquivo routes.php

```php
return function (RouteBuilder $routes): void {
    $routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
};

//Quando alguem acessar '/', estaremos trabalhando com controller Home e executar método index dentro de Home

```

- Podemos setar o nome da rota, passando \_name dentro de uma array e colocando o nome desejado, nesse exemplo: "home.index"

```php
  $routes->connect('/', ['controller' => 'Home', 'action' => 'index'], [
        '_name' => 'home.index'
    ]);
```

## Visualizar todas as rotas e Desabilitar debugKit

- Para visualizar todas as rotas, podemos utilizar o comando

- cake routes

para melhor visualização em src/Application.php podemos comentar a alinha que adiciona debug kit

```php
        if (Configure::read('debug')) {
            //$this->addPlugin('DebugKit');
        }

```

## Requisições POST

- Para trabalhar com diferentes tipo de requisição HTTP utilizamos o ->setMethods(['tipo_de requisição']);

```php
    $routes->connect('/about', ['controller' => 'About', 'action' => 'index'], [
        '_name' => 'about.index'
    ])->setMethods(['GET', 'POST']);
```

- Utilizando o comando cake routes, podemos ver que em methods ele exibe todos os metodos daquela rota get, post e etc.

## Requisções com parâmetros via URL

- Para os casos em que precisamos realizar uma busca GET de um parâmetro passado via URL exemplo:

```php
    $routes->connect('/product/{id}/name/{name}', ['controller' => 'Product', 'action' => 'show'], [
        '_name' => 'product.show',
        'pass' => ['id', 'name']
    ])->setMethods(['GET']);
```

## Expressão regular para validar dados na URL

- Para garantir que a informaçãp que vamos receber na URL é o tipo de dado que desejamos podemos validar o tipo de dado comuma expressãom regular ou REGEX na propria route.

Abrindo mais uma chave id e passando a expressão regular logo em seguida.
Nesse caso ele só aceitaria números.

O mesmos serviria para name, para aceitar somente caractéres minúsculos.

```php

  $routes->connect('/product/{id}', ['controller' => 'Product', 'action' => 'show'], [
        '_name' => 'product.show',
        'pass' => ['id'],
        'id' => '[0-9]+',
        'name' => '[a-z]+'
    ])->setMethods(['GET']);
```

## Simplificação das Routes

- Podemos usar o método diretamente em routhes sem utilizar setMethods exemplo:

```php
    $routes->get('/', ['controller' => 'Home', 'action' => 'index'], 'home.index');

    $routes->get('/about', ['controller' => 'About', 'action' => 'index'], 'about.index');

    $routes->get(
        '/product/{id}',
        ['controller' => 'Product', 'action' => 'show'],
        'product.show'
    )->setPatterns(['id' => '[0-9]+']);
```

- Porem em casos que a rota possui argumentos como no ultimo caso 'product/{id}'
  utilizamos ->'setPatterns' para o regex e não utilizamos o 'pass' para pegar o parâmetro via URL
  também é referenciado de uma maneira diferente nos Controllers

## Rota coringa \*

- Utilizado para URLs dinãmicas, slugs, categorias e etc.
  O \* funciona como um coringa (“wildcard”), capturando qualquer coisa depois da rota.
  exemplo:

```php
    $routes->connect('/clube/*', ['controller' => 'Clube', 'action' => 'index']);

public function index($arg1, $arg2)
  {
    var_dump($arg1, $arg2);
    die();
  }
```

e no controller seria capturado da mesma forma passando os $args na função.

## Scope

- Podemos agrupar as Rotas por scopo como global e admin

```php
    $routes->scope('/', function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Home', 'action' => 'index'], [
            '_name' => 'home.index'
        ])->setMethods(['GET']);

        $routes->connect('/about', ['controller' => 'About', 'action' => 'index'], [
            '_name' => 'about.index'
        ])->setMethods(['GET', 'POST']);

        $routes->connect('/product/{id}/name/{name}', ['controller' => 'Product', 'action' => 'show'], [
            '_name' => 'product.show',
            'pass' => ['id', 'name'],
            'id' => '[0-9]+',
            'name' => '[a-z]+'
        ])->setMethods(['GET']);
    });


    $routes->scope('/admin', function (RouteBuilder $routes) {
        $routes->connect(
            '/',
            ['controller' => 'Admin', 'action' => 'index'],
            ['_name' => 'admin.index']
        );
        $routes->connect(
            '/users',
            ['controller' => 'AdminUsers', 'action' => 'index'],
            ['_name' => 'adminusers.index']
        );
        $routes->connect(
            '/users/{id}',
            ['controller' => 'AdminUsers', 'action' => 'show'],
            [
                '_name' => 'adminusers.show',
                'pass' => ['id'],
                'id' => '[0-9]+'
            ]
        );
    });

```

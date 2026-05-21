# Controllers

- Para criação de um novo controller podemos o utilizar o comando

- cake bake controller --no-actions nome_do_controller
  --no-actions para não criar métodos adicionais.
  - Exemplo de um método dentro do controller

```php
class HomeController extends AppController
{
  public function index()
  {
    var_dump('index Home');
    die();
  }
}

```

## Capturando parâmetros passados via URL

- Para os casos que temos a rota:

```php
     $routes->connect('/product/{id}/name/{name}', ['controller' => 'Product', 'action' => 'show'], [
        '_name' => 'product.show',
        'pass' => ['id', 'name']
    ])->setMethods(['GET']);
```

Para ter acesso a {id} e {name} passamos como argumentos no controller no caso show()

```php
  public function show($arg1, $arg2)
  {
    var_dump('product show' . $arg1 . $arg2);
    die();
  }
```

- Caso a URL fosse

http://localhost:8765/product/12/name/notebook

- E a saída disso seria: productshow 12 notebook

## Capturando parâmetros passados via URL 2

- Em casos que as routes estão sendo utilizadas dessa forma:

```php
    $routes->get(
        '/product/{id}',
        ['controller' => 'Product', 'action' => 'show'],
        'product.show'
    )->setPatterns(['id' => '[0-9]+']);
```

Aqui nos controllers não vai funcionar pegar os argumentos dentro da de show($arg1)

Nesse caso fazemos assim:

Utilizamos '$this->request->getParam('parametro');

```php
  public function show()
  {
    var_dump('product show' . ' ' .  $this->request->getParam('id'));
    die();
  }
```

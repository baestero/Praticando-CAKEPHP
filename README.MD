# Estudos com CakePHP

Repositório de aprendizado em **CakePHP 4.5**. O foco deste README são as pastas numeradas com anotações de estudo — cada uma documenta um tópico praticado. A aplicação gerada pelo Composer (`my_app_name/`) é o ambiente onde os exemplos foram aplicados; os detalhes do framework ficam nas pastas abaixo.

## Estrutura do repositório

```
Praticando - CAKEPHP/
├── 001 - Instalação CAKE e Banco SQLite/
│   └── Anotação.md
├── 002 - Migrations/
│   └── Anotações.md
├── 003 - Seeds/
│   └── Anotações.md
├── 004 - Rotas/
│   └── Anotações.md
├── 005 - Controllers/
│   └── Anotações.md
├── 006 - Views/
│   └── Anotações.md
└── my_app_name/          # app CakePHP (prática dos tópicos acima)
```

| Pasta | Tópico | Arquivo de estudo |
|-------|--------|-------------------|
| `001 - Instalação CAKE e Banco SQLite` | Projeto novo + SQLite | [Anotação.md](001%20-%20Instalação%20CAKE%20e%20Banco%20SQLite/Anotação.md) |
| `002 - Migrations` | Estrutura do banco (tabelas, FK, alterações) | [Anotações.md](002%20-%20Migrations/Anotações.md) |
| `003 - Seeds` | Dados iniciais / fake com Faker | [Anotações.md](003%20-%20Seeds/Anotações.md) |
| `004 - Rotas` | Rotas, métodos HTTP, parâmetros, scope | [Anotações.md](004%20-%20Rotas/Anotações.md) |
| `005 - Controllers` | Bake, actions e parâmetros da URL | [Anotações.md](005%20-%20Controllers/Anotações.md) |
| `006 - Views` | Templates, layout, CSS, elementos | [Anotações.md](006%20-%20Views/Anotações.md) |

---

## 001 — Instalação do Cake e banco SQLite

### Criar o projeto

```bash
composer create-project --prefer-dist cakephp/app:~4.5 my_app_name
```

### Conexão com o banco

A conexão fica em `config/app_local.php`, na chave `Datasources`:

```php
'Datasources' => [
    'default' => [
        'className' => \Cake\Database\Connection::class,
        'driver' => \Cake\Database\Driver\Sqlite::class,
        'persistent' => false,
        'database' => ROOT . DS . 'db' . DS . 'database.sqlite',
        'encoding' => 'utf8',
        'cacheMetadata' => true,
        'quoteIdentifiers' => false,
    ],
],
```

Depois, criar a pasta e o arquivo do banco: `db/database.sqlite`.

**Anotações completas:** [001 - Instalação CAKE e Banco SQLite/Anotação.md](001%20-%20Instalação%20CAKE%20e%20Banco%20SQLite/Anotação.md)

---

## 002 — Migrations

Migrations são classes que criam ou alteram a estrutura do banco (tabelas, colunas, índices, chaves estrangeiras).

### Bake

No Cake, a geração de código costuma usar o comando **bake**:

```bash
bin/cake bake migration User
```

Isso cria a migration da tabela `users`. O bake já inclui `primaryKey` e autoincrement por padrão.

### Exemplo de criação de tabela

```php
$table = $this->table('users');

$table->addColumn('firstName', 'string', ['limit' => 100, 'null' => false]);
$table->addColumn('email', 'string', ['limit' => 100, 'null' => false]);
$table->addIndex('email', ['unique' => true]);

$table->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP']);
$table->addColumn('updated_at', 'timestamp', [
    'default' => 'CURRENT_TIMESTAMP',
    'update' => 'CURRENT_TIMESTAMP',
]);

$table->create();
```

Aplicar no banco:

```bash
bin/cake migrations migrate
```

### Chave estrangeira (ex.: posts → users)

```php
$table->addColumn('user_id', 'integer', ['null' => false]);
$table->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE']);
```

### Rollback

Remove a última migration aplicada:

```bash
bin/cake migrations rollback
```

### Alterar tabela existente

Para adicionar coluna em tabela já criada (ex.: `status` em `users`), criar uma nova migration e usar **`update()`** em vez de **`create()`**:

```php
$table = $this->table('users');
$table->addColumn('status', 'boolean', [
    'default' => 1,
    'null' => false,
]);
$table->update();
```

**Anotações completas:** [002 - Migrations/Anotações.md](002%20-%20Migrations/Anotações.md)

---

## 003 — Seeds

Seeds populam o banco com dados iniciais ou de teste. Quem clonar o projeto pode rodar migrations + seeds e já ter tabelas e registros.

### Criar seed

```bash
bin/cake bake seed NomeDaSeed
```

### Faker

Biblioteca para dados fake: [fakerphp/faker](https://github.com/FakerPHP/Faker).

```php
$faker = Faker\Factory::create();

for ($i = 1; $i <= 20; $i++) {
    $data['firstName'] = $faker->firstName();
    $data['lastName'] = $faker->lastName();
    $data['email'] = $faker->email();
    $data['password'] = password_hash('123', PASSWORD_DEFAULT);

    $table = $this->table('users');
    $table->insert($data)->save();
}
```

### Executar seeds

| Comando | Comportamento |
|---------|----------------|
| `bin/cake migrations seed` | Roda **todas** as seeds |
| `bin/cake migrations seed --seed NomeDaSeed` | Roda apenas uma seed |

**Importante:** rodar todas as seeds de novo **duplica** os dados (diferente das migrations, que só aplicam o que ainda não rodou). Depois da primeira carga, prefira a seed específica.

**Anotações completas:** [003 - Seeds/Anotações.md](003%20-%20Seeds/Anotações.md)

---

## 004 — Rotas

As rotas ficam em `config/routes.php`. Para subir o servidor em outra porta:

```bash
bin/cake server -p 8000
```

### Rota básica e nome

```php
$routes->connect('/', ['controller' => 'Home', 'action' => 'index'], [
    '_name' => 'home.index',
]);
```

Acesso a `/` → `HomeController::index()`.

### Listar rotas

```bash
bin/cake routes
```

Para visualizar melhor, em `src/Application.php` é possível comentar o plugin DebugKit no bloco `debug`.

### Métodos HTTP

```php
$routes->connect('/about', ['controller' => 'About', 'action' => 'index'], [
    '_name' => 'about.index',
])->setMethods(['GET', 'POST']);
```

### Parâmetros na URL (`pass` + regex)

```php
$routes->connect('/product/{id}/name/{name}', ['controller' => 'Product', 'action' => 'show'], [
    '_name' => 'product.show',
    'pass' => ['id', 'name'],
    'id' => '[0-9]+',
    'name' => '[a-z]+',
])->setMethods(['GET']);
```

### Forma simplificada (`get`, `setPatterns`)

```php
$routes->get('/', ['controller' => 'Home', 'action' => 'index'], 'home.index');

$routes->get(
    '/product/{id}',
    ['controller' => 'Product', 'action' => 'show'],
    'product.show'
)->setPatterns(['id' => '[0-9]+']);
```

Com `setPatterns`, os parâmetros são lidos no controller via `$this->request->getParam('id')` (ver `005`).

### Rota coringa (`*`)

URLs dinâmicas (slugs, categorias):

```php
$routes->connect('/clube/*', ['controller' => 'Clube', 'action' => 'index']);
```

No controller, os segmentos viram argumentos do método: `index($arg1, $arg2)`.

### Scope (agrupar rotas)

```php
$routes->scope('/', function (RouteBuilder $routes) {
    // rotas públicas: home, about, product...
});

$routes->scope('/admin', function (RouteBuilder $routes) {
    // rotas admin: /admin, /admin/users, /admin/users/{id}
});
```

**Anotações completas:** [004 - Rotas/Anotações.md](004%20-%20Rotas/Anotações.md)

---

## 005 — Controllers

### Criar controller (sem actions padrão)

```bash
bin/cake bake controller --no-actions NomeDoController
```

Exemplo mínimo:

```php
class HomeController extends AppController
{
    public function index()
    {
        // lógica da action
    }
}
```

### Parâmetros com `pass` na rota

Rota:

```php
$routes->connect('/product/{id}/name/{name}', ['controller' => 'Product', 'action' => 'show'], [
    'pass' => ['id', 'name'],
]);
```

Controller — argumentos na ordem dos placeholders:

```php
public function show($id, $name)
{
    // URL: /product/12/name/notebook → $id = 12, $name = notebook
}
```

### Parâmetros com `get()` + `setPatterns`

Rota:

```php
$routes->get('/product/{id}', ['controller' => 'Product', 'action' => 'show'], 'product.show')
    ->setPatterns(['id' => '[0-9]+']);
```

Controller — usar a request:

```php
public function show()
{
    $id = $this->request->getParam('id');
}
```

**Anotações completas:** [005 - Controllers/Anotações.md](005%20-%20Controllers/Anotações.md)

---

## 006 — Views

Convention: `templates/{Controller}/{action}.php` — ex.: `templates/Home/index.php` para `HomeController::index()`.

### Layout master

Criar `templates/layout/master.php` com o conteúdo principal:

```php
<?= $this->fetch('content') ?>
```

Na view:

```php
<?php $this->layout = 'master'; ?>
<h2>Home</h2>
```

### Bootstrap e container

Incluir o CSS do Bootstrap no `master` e envolver o conteúdo em `<div class="container">`.

### CSS por view

No `master`, incluir os blocos (como no `default.php`):

```php
<?= $this->fetch('css') ?>
<?= $this->fetch('script') ?>
```

Na view (`templates/Home/index.php`):

```php
<?php $this->layout = 'master'; ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="css/my_home.css">
<?php $this->end(); ?>

<h2>Home</h2>
```

Repetir o padrão para outras telas (ex.: `About` + `webroot/css/about.css`).

### Título dinâmico

No layout:

```php
<title><?php echo h($this->fetch('title', 'valor padrão')); ?></title>
```

Na view:

```php
<?php $this->assign('title', 'My Homepage with assign'); ?>
```

### Sidebar (element)

`templates/element/sidebar.php` com o HTML do menu.

No layout:

```php
<?= $this->fetch('sidebar') ?>
```

Na view:

```php
<?php $this->start('sidebar'); ?>
<?= $this->element('sidebar'); ?>
<?php $this->end(); ?>
```

### `render()` no controller

Em vez de `$this->layout` na view:

```php
return $this->render('index', 'master');
```

### Enviar dados para a view

```php
$name = 'Leonardo';
$age = '27';

$this->set(compact('name', 'age'));

return $this->render('index', 'master');
```

Na view: `<?php echo $name, $age; ?>`.

**Anotações completas:** [006 - Views/Anotações.md](006%20-%20Views/Anotações.md)

---

## Ordem sugerida para reproduzir os estudos

1. Instalar o projeto e configurar SQLite (`001`)
2. Criar e migrar tabelas (`002`)
3. Popular com seeds e Faker (`003`)
4. Definir rotas, scopes e parâmetros (`004`)
5. Criar controllers e capturar parâmetros (`005`)
6. Montar views, layout, CSS e elementos (`006`)

Na pasta `my_app_name/`, a prática correspondente fica em:

| Tópico | Caminhos na app |
|--------|-----------------|
| Banco | `config/Migrations/`, `config/Seeds/`, `db/database.sqlite` |
| Rotas | `config/routes.php` |
| Controllers | `src/Controller/` (Home, About, Product, Clube, Admin, AdminUsers…) |
| Views | `templates/`, `templates/layout/master.php`, `templates/element/sidebar.php` |
| Assets | `webroot/css/` (style.css, my_home.css, about.css…) |

---

## Referência rápida de comandos

```bash
# Projeto
composer create-project --prefer-dist cakephp/app:~4.5 my_app_name

# Servidor e rotas
bin/cake server -p 8000
bin/cake routes

# Migrations
bin/cake bake migration Nome
bin/cake migrations migrate
bin/cake migrations rollback

# Seeds
bin/cake bake seed NomeDaSeed
bin/cake migrations seed
bin/cake migrations seed --seed NomeDaSeed

# Controllers
bin/cake bake controller --no-actions NomeDoController
```

---

## Próximos tópicos

Novas pastas numeradas (`007 - ...`) podem seguir o mesmo padrão: pasta com `Anotações.md` (ou `Anotação.md`) e implementação correspondente em `my_app_name/`.

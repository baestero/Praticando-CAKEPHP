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
├── 007 - Crud com classe de conexão/
│   └── Anotações.md
├── 008 - Model e Entity/
│   └── Anotações.md
├── 009 - Relacionamentos/
│   └── Anotações.md
├── 010 - Paginação/
│   └── Anotações.md
├── 011 - Helpers/
│   └── Anotações.md
├── 012 - Cadastrando User/
│   └── Anotações.md
├── 013 - Validando Formulário/
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
| `007 - Crud com classe de conexão` | Connection, query builder, transactions | [Anotações.md](007%20-%20Crud%20com%20classe%20de%20conexão/Anotações.md) |
| `008 - Model e Entity` | Bake model, ORM, insert/update com entity | [Anotações.md](008%20-%20Model%20e%20Entity/Anotações.md) |
| `009 - Relacionamentos` | BelongsTo, HasMany, BelongsToMany | [Anotações.md](009%20-%20Relacionamentos/Anotações.md) |
| `010 - Paginação` | `paginate()`, helper Paginator, ordenação | [Anotações.md](010%20-%20Paginação/Anotações.md) |
| `011 - Helpers` | Url, Number, Html, Form (e Paginator) | [Anotações.md](011%20-%20Helpers/Anotações.md) |
| `012 - Cadastrando User` | Form helper, `patchEntity`, Flash | [Anotações.md](012%20-%20Cadastrando%20User/Anotações.md) |
| `013 - Validando Formulário` | `validationDefault`, regras na Table | [Anotações.md](013%20-%20Validando%20Formulário/Anotações.md) |

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

## 007 — CRUD com classe de conexão

A `Connection` abstrai o PDO. Use a conexão `default` configurada em `001`:

```php
use Cake\Datasource\ConnectionManager;

$connection = ConnectionManager::get('default');
$users = $connection->execute('SELECT * FROM users')->fetchAll('assoc');
```

### Insert com placeholders

```php
$connection->execute(
    'INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)',
    [
        'firstName' => 'Leonardo',
        'lastName' => 'Baestero',
        'email' => 'email@email.com',
        'password' => password_hash('123', PASSWORD_DEFAULT),
    ]
);
```

`fetchAll('assoc')` retorna array associativo; `fetchAll('obj')` retorna objetos (útil na view).

### Query Builder

```php
$users = $connection->selectQuery()
    ->select('*')
    ->from('users')
    ->where(['id >' => 5])
    ->execute()
    ->fetchAll('obj');

$connection->update('users', ['firstName' => 'Alexandre'], ['id' => 21]);

$connection->insert('users', [
    'firstName' => 'Leonardo',
    'lastName' => 'Baestero',
    'email' => 'email@email.com',
    'password' => '123',
]);
```

### Transaction e prepare

```php
$connection->begin();
$connection->execute('DELETE FROM users WHERE id = 21');
$connection->execute('UPDATE posts SET title = ? WHERE id = ?', ['Pedro', 26]);
$connection->commit();
```

```php
$prepare = $connection->prepare('SELECT * FROM users WHERE id > :id');
$prepare->bindValue('id', 5);
$prepare->execute();
$users = $prepare->fetchAll('obj');
```

**Anotações completas:** [007 - Crud com classe de conexão/Anotações.md](007%20-%20Crud%20com%20classe%20de%20conexão/Anotações.md)

---

## 008 — Model e Entity

### Criar model (tabela já existente)

```bash
bin/cake bake model users
```

Gera `src/Model/Table/UsersTable.php` e `src/Model/Entity/User.php`. A **Entity** representa um registro; a **Table** representa a tabela.

### Listagem com ORM

```php
use Cake\ORM\TableRegistry;

$tableUsers = TableRegistry::getTableLocator()->get('Users');
$users = $tableUsers->find();

$this->set(compact('users'));
$this->render('index', 'master');
```

### Consultas com ORM

```php
$users = $tableUsers->find()->where(['id >' => 10])->limit(5);

$users = $tableUsers->find('all', ['limit' => 10])
    ->where(['id >' => 10])
    ->order(['id' => 'DESC']);
```

### Insert e update com Entity

```php
$userEntity = $tableUsers->newEmptyEntity();
$userEntity->firstName = 'Alexandre';
$userEntity->lastName = 'Cardoso';
$userEntity->email = 'email1@email.com';
$userEntity->password = password_hash('123', PASSWORD_DEFAULT);
$tableUsers->save($userEntity);
```

- **Sem** `id` na entity → **insert**
- **Com** `id` na entity → **update**

```php
$userEntity = $tableUsers->newEmptyEntity();
$userEntity->id = 22;
$userEntity->firstName = 'Eduardo';
$tableUsers->save($userEntity);
```

**Anotações completas:** [008 - Model e Entity/Anotações.md](008%20-%20Model%20e%20Entity/Anotações.md)

---

## 009 — Relacionamentos

### BelongsTo (post pertence a um user)

```php
$tablePosts = TableRegistry::getTableLocator()->get('Posts');
$posts = $tablePosts->find()->contain(['Users']);
```

Na view: `$post->user->firstName`.

### HasMany (user tem muitos posts)

```php
$tableUsers = TableRegistry::getTableLocator()->get('Users');
$users = $tableUsers->find()->contain(['Posts']);
```

Na view: `count($user->posts)`.

### BelongsToMany (roles ↔ abilities)

Tabelas `roles`, `abilities` e pivot `abilities_roles` (nome em ordem alfabética).

```bash
bin/cake bake migration Roles
bin/cake bake migration Ability
bin/cake migrations migrate
bin/cake bake model Roles
bin/cake bake model Abilities
bin/cake bake migration AbilitiesRoles
```

Na migration da pivot:

```php
$table->addForeignKey('role_id', 'roles', 'id');
$table->addForeignKey('ability_id', 'abilities', 'id');
```

No controller:

```php
$tableRoles = TableRegistry::getTableLocator()->get('Roles');
$roles = $tableRoles->find()->contain(['Abilities']);
```

**Anotações completas:** [009 - Relacionamentos/Anotações.md](009%20-%20Relacionamentos/Anotações.md)

---

## 010 — Paginação

No controller, use o componente de paginação (herdado de `AppController`):

```php
$tableUsers = TableRegistry::getTableLocator()->get('Users');
$query = $tableUsers->find()->contain(['Posts']);

$users = $this->paginate($query, [
    'limit' => 15,
]);
```

### Helper Paginator (`AppView`)

```php
$this->loadHelper('Paginator', [
    'templates' => 'paginator',
]);
```

Templates em `config/paginator.php` (classes Bootstrap). Na view:

```php
<ul class="pagination">
  <?php
  echo $this->Paginator->first();
  echo $this->Paginator->prev();
  echo $this->Paginator->numbers();
  echo $this->Paginator->next();
  echo $this->Paginator->last();
  ?>
</ul>
```

Ordenação: `$this->Paginator->sort('firstName', 'Nome')`. Elementos reutilizáveis em `templates/element/paginator/`.

**Anotações completas:** [010 - Paginação/Anotações.md](010%20-%20Paginação/Anotações.md)

---

## 011 — Helpers

Por padrão o Cake carrega helpers comuns nas views. O **Paginator** não vem carregado — registre em `src/View/AppView.php` (ver `010`).

| Helper | Uso típico |
|--------|------------|
| **Url** | Links e URLs nomeadas |
| **Number** | Formatação numérica |
| **Html** | Tags HTML, links, imagens |
| **Form** | Formulários (`create`, `control`, `button`) |

Classes em `vendor/cakephp/cakephp/src/View/Helper/`.

**Anotações completas:** [011 - Helpers/Anotações.md](011%20-%20Helpers/Anotações.md)

---

## 012 — Cadastrando usuário

Action `add()` no controller:

```php
public function add()
{
    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $userEntity = $tableUsers->newEmptyEntity();

    if ($this->request->is('post')) {
        $userEntity = $tableUsers->patchEntity($userEntity, $this->request->getData());

        if ($tableUsers->save($userEntity)) {
            $this->Flash->success(__('Usuário cadastrado com sucesso'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Usuário não foi cadastrado'));
    }

    $this->set(compact('userEntity'));
    $this->render('add', 'master');
}
```

View `templates/Home/add.php`:

```php
<?= $this->Form->create($userEntity) ?>
<?= $this->Form->control('firstName', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Nome']]) ?>
<?= $this->Form->control('lastName', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Sobrenome']]) ?>
<?= $this->Form->control('email', ['class' => 'form-control', 'label' => ['class' => 'form-label']]) ?>
<?= $this->Form->control('password', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Senha']]) ?>
<?= $this->Form->button('Cadastrar', ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
```

No layout `master`: `<?= $this->Flash->render() ?>` e script do Bootstrap. Mensagens em `templates/element/flash/success.php` e `error.php`.

**Anotações completas:** [012 - Cadastrando User/Anotações.md](012%20-%20Cadastrando%20User/Anotações.md)

---

## 013 — Validando formulário

Regras em `src/Model/Table/UsersTable.php`, método `validationDefault()` — aplicadas ao `patchEntity()` / `save()`:

```php
public function validationDefault(Validator $validator): Validator
{
    $validator
        ->scalar('firstName')
        ->maxLength('firstName', 100)
        ->requirePresence('firstName', 'create')
        ->notEmptyString('firstName', 'Necessário preencher o campo');

    $validator
        ->email('email')
        ->requirePresence('email', 'create')
        ->notEmptyString('email', 'Necessário preencher o campo')
        ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

    // demais campos: lastName, password, etc.

    return $validator;
}
```

Unicidade de e-mail também em `buildRules()`:

```php
public function buildRules(RulesChecker $rules): RulesChecker
{
    $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
    return $rules;
}
```

Erros aparecem automaticamente nos campos do `Form->control()` quando o save falha.

**Anotações completas:** [013 - Validando Formulário/Anotações.md](013%20-%20Validando%20Formulário/Anotações.md)

---

## Ordem sugerida para reproduzir os estudos

1. Instalar o projeto e configurar SQLite (`001`)
2. Criar e migrar tabelas (`002`)
3. Popular com seeds e Faker (`003`)
4. Definir rotas, scopes e parâmetros (`004`)
5. Criar controllers e capturar parâmetros (`005`)
6. Montar views, layout, CSS e elementos (`006`)
7. CRUD com Connection e query builder (`007`)
8. Models, entities e ORM (`008`)
9. Relacionamentos BelongsTo, HasMany e BelongsToMany (`009`)
10. Paginação e templates do Paginator (`010`)
11. Conhecer os helpers (Url, Html, Form…) (`011`)
12. Formulário de cadastro com Flash (`012`)
13. Validação na Table e regras de integridade (`013`)

Na pasta `my_app_name/`, a prática correspondente fica em:

| Tópico | Caminhos na app |
|--------|-----------------|
| Banco | `config/Migrations/`, `config/Seeds/`, `db/database.sqlite` |
| Rotas | `config/routes.php` |
| Controllers | `src/Controller/` (Home, About, Product, Clube, Admin…) |
| Models | `src/Model/Table/`, `src/Model/Entity/` |
| Views | `templates/`, `templates/layout/master.php`, `templates/element/` |
| Paginação | `config/paginator.php`, `templates/element/paginator/` |
| Form / Flash | `templates/Home/add.php`, `templates/element/flash/`, `AppController` (Flash) |
| Assets | `webroot/css/` |

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

# Models
bin/cake bake model users
```

---

## Próximos tópicos

Novas pastas numeradas (`014 - ...`) podem seguir o mesmo padrão: pasta com `Anotações.md` (ou `Anotação.md`) e implementação correspondente em `my_app_name/`.

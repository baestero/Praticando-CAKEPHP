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
└── my_app_name/          # app CakePHP (prática dos tópicos acima)
```

| Pasta | Tópico | Arquivo de estudo |
|-------|--------|-------------------|
| `001 - Instalação CAKE e Banco SQLite` | Projeto novo + SQLite | [Anotação.md](001%20-%20Instalação%20CAKE%20e%20Banco%20SQLite/Anotação.md) |
| `002 - Migrations` | Estrutura do banco (tabelas, FK, alterações) | [Anotações.md](002%20-%20Migrations/Anotações.md) |
| `003 - Seeds` | Dados iniciais / fake com Faker | [Anotações.md](003%20-%20Seeds/Anotações.md) |

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

## Ordem sugerida para reproduzir os estudos

1. Instalar o projeto e configurar SQLite (`001`)
2. Criar e migrar tabelas (`002`)
3. Popular com seeds e Faker (`003`)

Na pasta `my_app_name/`, os arquivos gerados na prática ficam em:

- `config/Migrations/` — migrations (User, Post, coluna status, etc.)
- `config/Seeds/` — seeds (User, Post, DatabaseSeed)

---

## Referência rápida de comandos

```bash
# Projeto
composer create-project --prefer-dist cakephp/app:~4.5 my_app_name

# Migrations
bin/cake bake migration Nome
bin/cake migrations migrate
bin/cake migrations rollback

# Seeds
bin/cake bake seed NomeDaSeed
bin/cake migrations seed
bin/cake migrations seed --seed NomeDaSeed
```

---

## Próximos tópicos

Novas pastas numeradas (`004 - ...`) podem seguir o mesmo padrão: pasta com `Anotações.md` (ou `Anotação.md`) e implementação correspondente em `my_app_name/`.

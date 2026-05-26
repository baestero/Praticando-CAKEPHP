# Relacionamentos

- A tabela posts tem a chave estrangeira (ForeignKey) user_id

## BelongsTo

- Quando um usuário cria um post ele (Belongs) pertence a um usuário

- Aqui pegamos a tabela posts e procuramos um relacionamento com o nome da tabela Users e não a coluna user_id por exemplo.

- Mandamos as informações de post para nossa view

```php
  $tablePosts = TableRegistry::getTableLocator()->get('Posts');
    $posts = $tablePosts->find()->contain(['Users']);


    $this->set(compact('posts'));
    $this->render('index', 'master');
```

- Na view fazemos um looping mostrando todos os posts e primeiro nome de cada usuário dono do post.

```php

<ul>
  <?php foreach ($posts as $post): ?>
    <li><?php echo  $post->id ?> <?php echo $post->title ?> | author: <?php echo $post->user->firstName; ?></li>
  <?php endforeach; ?>
</ul>

```

## Hasmany

- O usuário pode criar quantos posts quiser, então o usuário (Hasmany) tem muitos posts

Nesse exemplo vamos mostrar quantos posts cada usuário tem:

- No controller pegamos a tabela users e procuramos o relacionamento com a tabela posts e enviamos pra nossa view

```php

    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $users = $tableUsers->find()->contain(['Posts']);

    $this->set(compact('users'));

```

- Na view fazendo um looping pegando todos os usuários exebindo o primeiro nome e a contagem de posts daquele usuário.

```php
<ul>
  <?php foreach ($users as $user): ?>
  <li><?php echo  $user->id ?> <?php echo $user->firstName ?> | posts: <?php echo count($user->posts) ?></li>
  <?php endforeach; ?>
</ul>

```

## Belongs to Many

- Quando uma regra pertence á muitas habilidades
- E uma habilidade pertence há muitas regras.

roles / abilities
admin -> criar_post
admin -> update_post
guest -> criar_post
guest -> update_post
employee -> update_post

- Vamos criar as tabelas roles e ability
- E uma tabela que vai realizar a ligação entre as duas que precisa se chamar abilitysRolles

- cake bake migration Roles
- cake bake migration Ability

```php
    $table = $this->table('roles');
        $table->addColumn('name', 'string', [
            'limit' => 100,
        ]);
        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);

        $table->create();
```

- cake bake migrations migrate

- Após a criação das migrations roles e ability

- Vamos criar as Models Roles e Abilities também
- cake bake model Roles e após abilities

(O nome da model segue o nome da tabela criada)

- Agora vamos criar a tabela abilities_roles
  cake bake migration AbilitiesRoles e adicionar as chaves estrangeiras.

  Vai ser a tabela que vai ser dado JOIN e precisa seguir essa nomenclatura por ordem alfabetica

  Abilities Roles

  ```php
     $table = $this->table('abilities_roles');
        $table->addColumn('role_id', 'integer', [
            'limit' => 100,
        ]);
        $table->addColumn('ability_id', 'integer', [
            'limit' => 100,
        ]);
        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);

        $table->addForeignKey('role_id', 'roles', 'id');
        $table->addForeignKey('ability_id', 'abilities', 'id');

        $table->create();
    }
  ```

  - Apos a criação das models Roles e Abilities o relacionamento aparecerá na model o relacionamento configurado como
    - bellongstomany

    ```php

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('abilities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Roles', [
            'foreignKey' => 'ability_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'abilities_roles',
        ]);
    }
    ```

- No controller passamos o tableRoles, passandos os roles e suas abilities relacionados e mandamos para nossa view

```php

    $tableRoles = TableRegistry::getTableLocator()->get('Roles');
    $users = $tableRoles->find()->contain(['Abilities']);

    $this->set(compact('users', 'posts', 'roles'));
```

na table abilities_roles relacionamentos ability_id com role_id e o php ja reconheceu esse relacionamento, com create e update post para o role admin

```php
<ul>
  <?php foreach ($roles as $role): ?>
    <li><?php dd($role); ?></li>
  <?php endforeach; ?>
</ul>
```

```php
object(App\Model\Entity\Role) id:0 {
'id' => (int) 1
'name' => 'admin'
'created_at' => object(Cake\I18n\FrozenTime) id:1 { }
'updated_at' => object(Cake\I18n\FrozenTime) id:2 { }
'abilities' => [
(int) 0 => object(App\Model\Entity\Ability) id:3 {
'id' => (int) 2
'name' => 'update_post'
'created_at' => object(Cake\I18n\FrozenTime) id:4 { }
'updated_at' => object(Cake\I18n\FrozenTime) id:5 { }
'_joinData' => object(Cake\ORM\Entity) id:6 { }
'[new]' => false
'[accessible]' => [ ]
'[dirty]' => [ ]
'[original]' => [ ]
'[virtual]' => [ ]
'[hasErrors]' => false
'[errors]' => [ ]
'[invalid]' => [ ]
'[repository]' => 'Abilities'
},
(int) 1 => object(App\Model\Entity\Ability) id:9 {
'id' => (int) 1
'name' => 'create_post'
'created_at' => object(Cake\I18n\FrozenTime) id:10 { }
'updated_at' => object(Cake\I18n\FrozenTime) id:11 { }
'_joinData' => object(Cake\ORM\Entity) id:12 { }
'[new]' => false
'[accessible]' => [ ]
'[dirty]' => [ ]
'[original]' => [ ]
'[virtual]' => [ ]
'[hasErrors]' => false
'[errors]' => [ ]
'[invalid]' => [ ]
'[repository]' => 'Abilities'
},
]
```

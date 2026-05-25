# Model

- Criando a model
  - cake bake model nome_da_tabela
    se tivermos uma tabela chamada users, o nome da model precisa ser users.

Para criar uma model já precisamos ter o banco e tabela criados.

Quando concluido será criada a entity e table dentro de src/model/entity ou table.

# Entity

- é cada registro de uma tabela.

## Exibindo a listagem de usuários ORM query.php

1. Pelo ORM do cake oegamis a model/tabela de 'Users' do cake e guardamos na variável $tableUsers
   obs: o nome da tabela é 'users', porém 'Users' é o alias.

2. Depois criamos uma consulta (SELECT \* FROM users)e guarda o resultado em $users

3. mandamos o resultado para view com this->set()

4. chamamos a view Home/index.php do layout master.

```php
    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $users = $tableUsers->find();

    $this->set(compact('users'));

    $this->render('index', 'master');

```

- Podemos montar a Query livremente utilizando o ORM exemplo:

```php
    $users = $tableUsers->find()->where(['id >' => 10])->limit(5);

    //ou

    $users = $tableUsers->find('all', ['limit' => 5])->where(['id >' => 10])

    //order
      $users = $tableUsers->find('all', ['limit' => 10])
      ->where(['id >' => 10])
      ->order('id desc');

```

## Insert & Update utilizando Entity

- Começamos chamando tableUsers e criando uma nova entity vazia, que não é nada mais que um registro na tabela, Porém vazio, se tratando da tabela users, é um novo user, vazio, onde vamos setando os campos e valores.

```php
    $userEntity = $tableUsers->newEmptyEntity();

    $userEntity->firstName = 'Alexandre';
    $userEntity->lastName = 'Cardoso';
    $userEntity->email = 'email1@email.com';
    $userEntity->password = password_hash('123', PASSWORD_DEFAULT);

    $tableUsers->save($userEntity);
```

- Para realizar o update é o mesmo processo, porém passamos o id do usuário que iremos alterar e a Alteração que desejamos, nesse caso atualizamos o primeiro nome do user com id 22 para Eduardo.

```php
    $userEntity = $tableUsers->newEmptyEntity();

    $userEntity->id = 22;
    $userEntity->firstName = 'Eduardo';

    $tableUsers->save($userEntity);
```

- Quando eu crio uma entity vazia, newEmptyEntity e **Não** passo o ID ele faz o insert, ele cadastra um novo usuário

- Quando eu crio uma entity vazia, e **Passo** o id ele faz o update.

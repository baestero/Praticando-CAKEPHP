## Conection

- Interface simples para interagir com banco de dados, classe de abstração em cima do PDO.

Aqui pegamos a conexão com banco de dados.

Utilizamos o banco 'default' que é o que configurei na pasta 001 - Instalação cake e banco de dados.

```php
  $connection = ConnectionManager::get('default');
```

- Para pegar todos os usuarios do banco podemos escrever a query diretamente com:

```php
  $users = $connection->execute('select * from users')->fetchAll('assoc');
  dd($users);;
```

## Insert

- Também podemos usar o execute para fazer inserts, updates ou deletes

```php
 $connection->execute(
      'insert into users(firstName, lastName, email, password) values (:firstName,:lastName, :email, :password )',
      [
        'firstName' => 'Leonardo',
        'lastName' => 'Baestero',
        'email' => 'email@email.com',
        'password',
        password_hash('123', PASSWORD_DEFAULT),
      ]
    );

```

A query retornará em um array php todos os usuários, utilizamos 'assoc' retornar os dados como um array associativo e 'dd' users, para formatar e melhorar a visualização.

Também podemos retornar o array como objeto ('obj')

## Passando os dados de users para a view

- Agora que já temos o array com todos os usuários, podemos passar esses dados para view utilizando

```php
    $connection = ConnectionManager::get('default');
    $users = $connection->execute('select * from users')->fetchAll('obj');
    $this->set(compact('users')
```

- Agora na view podemos utilizar users dessa forma:

```php
<ul>
  <?php foreach ($users as $user): ?>
  <li><?php echo  $user->id ?> <?php echo $user->firstName ?></li>
  <?php endforeach; ?>
</ul>
```

Assim teremos uma lista na view com id e primeiro nome de cada usuário na tela.

## Query Builder

- A nossa primeira query pode ser reescrita utilizando query builder dessa forma:

```php
$users = $connection->execute('select \* from users where id > 5')->fetchAll('obj');

$users = $connection->selectQuery()->select('*')->from('users')->where(['id >'=>5])->execute()->fetchAll('obj');
```

- Podemos também utilizar no Update

```php

    $users = $connection->update('users', [
      'firstName' => 'Alexandre',
    ], ['id' => 21]);
```

- Podemos também utilizar no Insert

```php
      $users = $connection->insert('users', [
      'firstName' => 'Leonardo',
      'lastName' => 'Baestero',
      'email' => 'email@email.com',
      'password' => '123',
    ]);
```

## Transaction

- begin e commit isolam uma transaction que nesse caso a segunda query update está errada.
  E esse exemplo é pra mostrar que caso uma query esteja incorreta ele não executará nenhuma query, mesmo sendo certa que é no caso do delete.

```php

    $connection->begin();
    $connection->execute('delete from users where id = 21');
    $connection->execute('update postss set firstname = "Pedro" where id = 26');
    $connection->commit();
```

## Prepare

- Realizando mesma consulta da lista de usuários utilizando prepare()

```php

    $prepare = $connection->prepare('SELECT * FROM users WHERE id > :id');
    $prepare->bindValue('id', 5);
    $prepare->execute();
    $users = $prepare->fetchAll('obj');
```

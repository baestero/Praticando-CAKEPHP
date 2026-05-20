# Migrations

- São classes que onde cada classe criara uma tabela no banco de dados.
  Migrations são utilizadas para criar e alterar estrutura do banco

## Para criar qualquer coisa no cake usamos o comando 'BAKE'

- cake bake migration User
  Estaremos criando a migration para criação da tabela Users

## Criação de tabela

- Obs: Automaticamente ele cria com primaryKey e com autoincrement

  Comando para criar migration

- //cake bake migration User

```php
        $table =  $this->table('users');
        // criando a tabela users

        $table->addColumn('firstName', 'string', ['limit' => 100, 'null' => false,]);
        //adicionando coluna firstName e o segundo parametro é o tipo de dado string
        // no array colocamos as opções como limit e null.

        $table->addColumn('email', 'string', [
            'limit' => 100,
            'null' => false,
        ]);
        $table->addIndex('email', ['unique' => true]);
        //email do tipo unico com addIndex


       $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

       // para mostrar a data que foi criado e alterado

        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
        ]);


        $table->create();}
        //cria a tabela
        // comando: cake migrations migrate
```

## ForeignKey

```php
      //Exemplo de criação de coluna com chave estrangeira e como relacionar
      // Tambem exemplo utilizando delete CASCADE.

      $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);
      $table->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'CASCADE'
        ]);
```

## Rollback

- cake migrations rollback

- Estará removendo sempre a ultima migration que foi adicionada ao banco

## Adicionar uma nova coluna a uma tabela já criada

- Nesse exemplo foi necessário adicionar o campo 'status' na tabela users
- Foi criado uma nova migration chamada Create_status_User_Column
- E dentro dela foi adicionado o novo campo referenciando a tabela users

- Porém ao invés de utilizar a table->create, utilizamos a table->update para atualizar a tabela.

```php
       $table = $this->table('users');
       $table->addColumn('status', 'bolean', [
           'default' => 1,
           'null' => false,
       ]);
       $table->upadte();
```

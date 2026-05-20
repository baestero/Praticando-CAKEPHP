# Seeds

- Popula o banco com dados iniciais/fake

- Para quem rodar meu projeto e rodar as migrations e seeds vai ter o banco de dados com tabelas e dados criados.

- para criar uma classe de seed
- cake bake seed nome_da_seed

## Faker

- Biblioteca para geração de dados fake/testes
  Realizar a instação da biblioteca fakerphp/faker

  comando para utilizar na SEED
  $faker = Faker\Factory::create();

```php
  for ($i = 1; $i <= 20; $i++) {
            $data['firstName'] = $faker->firstName();
            $data['lastName'] = $faker->lastName();
            $data['email'] = $faker->email();
            $data['password'] = password_hash(password: '123', algo: PASSWORD_DEFAULT);

            $table = $this->table('users');
            $table->insert($data)->save();
        }
```

Após isso é feito um for para adicionar 20 registros na tabela users
com 3 metodos do faker e no password uma função nativa do PHP

comando para rodar a seed

- cake migrations seed (roda todas as seeds)
  - Caso rodar todas as seeds mesmo ja tendo rodado as anteriores, elas rodaram novamente e duplicarão os dados então precisa-se rodar a seed especifica que foi adicionada, não tem o mesmo comportamento das migrations, que mesmo rodando todas, só adiciona a ultima.

- cake migrations seed --seed nome_da_seed (roda todas as seeds)

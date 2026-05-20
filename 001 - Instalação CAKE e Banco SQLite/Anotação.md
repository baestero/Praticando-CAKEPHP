# Instalação do CAKE

- composer create-project --prefer-dist cakephp/app:~4.5 my_app_name

# Conexão com banco de dados

- Em config/app_local.php
  é onde vamos configurar a conexão com banco de dados

1.  configurar a conexão com sqlite config/app_local.php

```
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

2. Criar pasta e arquivo db/database.sqlite

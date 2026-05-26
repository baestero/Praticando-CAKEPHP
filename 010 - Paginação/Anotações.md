# Paginação

- Para paginarmos os registros, exemplo usuários devemos no controller

1. Selecionar a tabela users e dar o find(), a relação com a tabelas posts foi opcional

2. chamar o this->paginate e limitar em quantos registro quer por página.

```php

    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $query = $tableUsers->find()->contain(['Posts']);

    $users = $this->paginate($query, [
      'limit' => 15,
    ]);

    dd($users);

    die();


```

## Paginação na view com Helper paginator

- Em src/View/AppView.php a função initizalize() vamos chamar o paginator, o nome pode ser o que preferir

```php
    public function initialize(): void
    {
        $this->loadHelper('Paginator', [
            'templates' => 'paginator',
        ]);
    }
```

- Na View chamamos o helper, metodos e colocamos num container pagination do bootstrap

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

- Após vamos criar o arquivo paginator dentro de /config/paginator.php e dentro dele o cake pede que deve ser retornado um array, e é isso que fazemos.

```php
<?php
return [
  'first' => '<li class="page-item"><a href="{{url}}" class="page-link">Primeira</a></li>',
  'current' => '<li class="page-item active"><a class="page-link">{{text}}</a></li>',
  'prevActive' => '<li class="page-item"><a href="{{url}}" class="page-link">Anterior</a></li>',
  'prevDisabled' => '',
  'number' => '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
  'nextActive' => '<li class="page-item"><a href="{{url}}" class="page-link">Próxima</a></li>',
  'nextDisabled' => '',
  'sortAsc' => '<a href={{url}} class="sortAsc">{{text}}<i class="bi bi-arrow-up"></i></a>',
  'sortDesc' => '<a href={{url}} class="sortAsc">{{text}} <i class="bi bi-arrow-down"></i></a>',
  'last' => '<li class="page-item"><a href="{{url}}" class="page-link">Ultima</a></li>',
];

```

- Front ja começa a paginar a partir daqui.

## Ordenando por asc, desc.

- No index.php podemos ordenar os dados mostrados, e queremos aqui, ordenar pelo nome e sobrenome com
  Paginator->sort();
  - Foi utilizado divs e span, com classes css comuns no arquivo master ou especifico da view para estilização padrão, como flexbox e etc ...

```php
<div class="sorts">
  <span class="sort">Organizar por:</span>

  <span class="sort">
    <?php echo $this->Paginator->sort('firstName', 'Nome'); ?>
  </span>

  <span class="sort">
    <?php echo $this->Paginator->sort('lastName', 'SobreNome'); ?>
  </span>
</div>

<ul>
 <?php foreach ($users as $user): ?>
   <li><?php echo  $user->id ?> <?php echo $user->firstName ?> | posts: <?php echo count($user->posts) ?></li>
 <?php endforeach; ?>
</ul>

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

## Organização

- O componente de paginação ele colocou em src/templates/paginator/simple.php (sem o contador de paginas)

- src/templates/paginator/advanced.php (com o contador de paginas)

-src/templates/paginator/sortUsers.php (com a ordenação dos usuários)

```php
<ul class="pagination">
  <?php
  echo $this->Paginator->first();
  echo $this->Paginator->prev();
  echo $this->Paginator->numbers();
  echo $this->Paginator->next();
  echo $this->Paginator->last();
  ?>

  <?= $this->Paginator->counter('range'); ?>
  <?= $this->Paginator->counter('pages'); ?>
</ul>

```

```php
<div class="sorts">
  <span class="sort">Organizar por:</span>

  <span class="sort">
    <?php echo $this->Paginator->sort('firstName', 'Nome'); ?>
  </span>

  <span class="sort">
    <?php echo $this->Paginator->sort('lastName', 'SobreNome'); ?>
  </span>
</div>

```

- E só chamou no index.php

```php
<?= $this->element('paginator/sortUsers'); ?>

<ul>
  <?php foreach ($users as $user): ?>
    <li><?php echo  $user->id ?> <?php echo $user->firstName ?> <?php echo $user->lastName ?> | posts: <?php echo count($user->posts) ?></li>
  <?php endforeach; ?>
</ul>


<?= $this->element('paginator/simple'); ?>

```

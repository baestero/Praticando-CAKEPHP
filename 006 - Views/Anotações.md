# Views

- Para criar uma View precisamos criar uma pasta com o mesmo nome do controller e um arquivo com mesmo nome do método.

ex: templates/Home/index.php

```php
class HomeController extends AppController
{
  public function index()
  {
    var_dump('index Home');
    die();
  }
}
```

## Criando layout master

- Dentro de layout criamos o arquivo master.php ou do nome que preferrir.
  ex: templates/layout/master.php

Dentro de tenplates/Home/index.php inserimos o código

```php
<?php
$this->layout = 'master';
```

Dentro de templates/layout/default.php

pegamos o código:

```php
        <?= $this->fetch('content') ?>
```

e inserimos no nosso templates/layout/master.php

Apartir disso, todos templater vão ser carregados do master.php

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>

  <body>
    <h2>Curso de cakePHP</h2>
    <?php $this->fetch('content') ?>
  </body>
</html>
```

- Agora podemos pegar o Templates/Home/index.php
  Utilizar o layout padrão master e colocar o que desejamos no caso um h2 com titulo Home.

```html
<?php
$this->layout = 'master'; ?>

<h2>Home</h2>
```

## Bootstrap

- Para utilizar o framework de CSS, o Bootstrap, pegamos utilizamos o link presente no get bootstrap.

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

- No nosso layout master colocamos nosso conteudo dentro de um container com uma classe 'container'

```html
<body>

  <h2>Curso de cakePHP</h2>

  <div class="container">
    <?= $this->fetch('content') ?>
  </div>

</body>

</html>
```

## CSS

- Criamos nosso arquivo de CSS em: webroot/css/style.css

- Porém nós queremos quecada view tenha seu CSS especifico e para isso copiamos os comandos no templates/layout/deafult.php

```php
<?= $this->fetch('css') ?>
<?= $this->fetch('script') ?>
```

e cola no templates/layout/master.php

no seu template especifico no caso o Index.php da tela home

injetamos css dessa forma: criamos dentro de webroot/css/my_home.css
que faz referencia a view da home e chamamos ela dentro do template index.php de Home.

Templates/Home/index.php e com isso o css estará linkado e funcionando.

```php
<?php $this->layout = 'master'; ?>

<?php $this->start('css'); ?>

<link rel="stylesheet" href="css/my_home.css">

<?php $this->end(); ?>

<h2>Home</h2>
```

- Agora é só repetir para as outras telas como About por exemplo.

O passo a passo a partir daqui seria:

1. criar a pasta About nos templates
2. criar dentro de About o index.php que é o metodo que chama no controller about=>index
3. dentro de index.php colocar o mesmo html de Home/index.php
4. criar um css dentro de webroot/css com nome de about.css
5. linkar o about.css no arquivo dentro de Templates/about/index.php

Pronto, já teriamos nosso css personalizado por view.

## Title dinâmico por view

- O title sempre é definido pelo nome do controller, porém se caso seja necessário alterar o título da page podemos fazer o seguinte:

- No arquivo templates/master.php

```php
 <title>?php echo h($this->fetch('title', 'valor_padrao quando não há title definido'))?></title>
```

- Podemos também personalizar o titulo da página injetando:

```php
<?php $this->assign('title', 'My Homepage with assign') ?>
```

Logos após salvar o tituo da página agora seria 'My Home Page'.

## Sidebar

- Componente visuais que vamos repetir em varios lugáres do nosso site como a sidebar podemos fazer o seguinte:

Em templates/master.php podemos realizar a chamada do sidebar

```php
  <div class="container">
    <h2>Curso de cakePHP</h2>
    <?= $this->fetch('content') ?>
    <?= $this->fetch('sidebar') ?>
  </div>
```

- Em templates/elements criamos o arquivo sidebar.php e lá colocamos o conteudo de sidebar ex:

```php
<ul>
  <li><a href="/">Home</a></li>
  <li><a href="/about">About</a></li>
</ul>
```

E realizamos a chamada da sidebar em todos arquivos que queremos utilizando

ex: Home, About e etc..

```php
<?php $this->start('sidebar') ?>
<?php echo $this->element('sidebar'); ?>
<?php $this->end('sidebar') ?>
```

## Trabalhando com render()

- Para utilizarmos o render podemos remover a chamada ao arquivo master dos templates

```php
<?php $this->layout = 'master'; ?>
```

E nos controllers onde está o metódo relacionado a view vamos utilizar o render.

Utilizando o nome do método e o layout padrão.

```php
  return $this->render('index', 'master');
```

## Passando um valor do controller para a view

- Exemplo de como passar um valor que vem do controller para a view.

Aqui passamos o nome e a idade de Leonardo e usamos o this-> set e colocamos as duas variáveis

```php

  public function index()
  {
    $name = 'Leonardo';
    $age = '27';

    $this->set(compact('name', 'age'));

    return $this->render('index', 'master');
  }

```

- Em Templates/Home/index.php se passarmos dentro de um echo $name e $age ele aparecerá na view o conteúdo dessas duas variáveis.

```php
<h2>Home <?php echo $name, $age; ?> </h2>
```

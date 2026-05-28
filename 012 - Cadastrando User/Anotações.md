# Cadastrando um usuário

- No controler vamos criar um novo método chamado add()

- E criamos nossa view de add em templates/home/add.php pois estamos manipulando ainda o controller Home.

```php
  public function add()
  {
    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $userEntity = $tableUsers->newEmptyEntity();

    if ($this->request->is('post')) {
      $userEntity = $tableUsers->patchEntity($userEntity, $this->request->getData());

      if ($tableUsers->save($userEntity)) {
        $this->Flash->success(__('Usuário Cadastrado com sucesso'));
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('Usuário não foi cadastrado com sucesso'));
      }
    }

    $this->set(compact('userEntity'));

    $this->render('add', 'master');
  }
}


```

- Pegamos a tabela TableUsers, declaramos uma nova entity vazia que seria uma novo usuário e mandamos para nossa view.

- Verificamos se a request é um post, se for, pegamos os dados da request que vai vir via form e criamos um novo usuário

Na view chamamos o form create/end e passamos nosso userEntity que enviamos via controller.

- Utilizamos a Form para criação dos formulário e as classes do bootstrap para estilização

```php
<h2>Cadastrar Usuário</h2>

<?= $this->Form->create($userEntity) ?>
<?= $this->Form->control('firstName', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Nome']]); ?>
<?= $this->Form->control('lastName', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Sobrenome']]); ?>
<?= $this->Form->control('email', ['class' => 'form-control', 'label' => ['class' => 'form-label']]); ?>
<?= $this->Form->control('password', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Senha']]); ?>
<?= $this->Form->button('Cadastrar', ['class' => 'btn btn-primary']); ?>
<?= $this->Form->end() ?>
```

- Para mudar a estilização das mensagens de erro e sucesso no cake é só alterar o arquivo, templates/elements/flash/error e success.php

Também é necessário carregar o script do bootstrap e o flash dentro da master

```php
<body>

  <div class="container">
    <h2>Curso de cakePHP</h2>
    <?= $this->Flash->render() ?>  <-
    <?= $this->fetch('content') ?>
    <?= $this->fetch('sidebar') ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script> <-
</body>

```

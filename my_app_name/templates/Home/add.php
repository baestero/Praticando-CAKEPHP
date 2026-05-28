<?php $this->start('css'); ?>
<link rel="stylesheet" href="css/my_home_add.css">
<?php $this->end(); ?>

<?php $this->start('sidebar') ?>
<?php echo $this->element('sidebar'); ?>
<?php $this->end('sidebar') ?>


<h2>Cadastrar Usuário</h2>

<?= $this->Form->create($userEntity) ?>
<?= $this->Form->control('firstName', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Nome']]); ?>
<?= $this->Form->control('lastName', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Sobrenome']]); ?>
<?= $this->Form->control('email', ['class' => 'form-control', 'label' => ['class' => 'form-label']]); ?>
<?= $this->Form->control('password', ['class' => 'form-control', 'label' => ['class' => 'form-label', 'text' => 'Senha']]); ?>
<?= $this->Form->button('Cadastrar', ['class' => 'btn btn-primary']); ?>
<?= $this->Form->end() ?>
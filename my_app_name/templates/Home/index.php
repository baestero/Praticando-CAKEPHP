<?php $this->start('css'); ?>
<link rel="stylesheet" href="css/my_home.css">
<?php $this->end(); ?>

<?php $this->assign('title', 'My Homepage with assign') ?>

<?php $this->start('sidebar') ?>
<?php echo $this->element('sidebar'); ?>
<?php $this->end('sidebar') ?>


<h2>Home</h2>

<?= $this->element('paginator/sortUsers'); ?>

<ul>
  <?php foreach ($users as $user): ?>
    <li><?php echo  $user->id ?> <?php echo $user->firstName ?> <?php echo $user->lastName ?> | posts: <?php echo count($user->posts) ?></li>
  <?php endforeach; ?>
</ul>


<?= $this->element('paginator/simple'); ?>
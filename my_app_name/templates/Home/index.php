<?php $this->start('css'); ?>
<link rel="stylesheet" href="css/my_home.css">
<?php $this->end(); ?>

<?php $this->assign('title', 'My Homepage with assign') ?>

<?php $this->start('sidebar') ?>
<?php echo $this->element('sidebar'); ?>
<?php $this->end('sidebar') ?>


<h2>Home <?php echo $name, $age; ?> </h2>
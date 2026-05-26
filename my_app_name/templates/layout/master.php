<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
  <title><?php echo h($this->fetch('title', 'Curso de CakePHP 4')) ?></title>
</head>

<body>

  <div class="container">
    <h2>Curso de cakePHP</h2>
    <?= $this->fetch('content') ?>
    <?= $this->fetch('sidebar') ?>
  </div>

</body>

</html>
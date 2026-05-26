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
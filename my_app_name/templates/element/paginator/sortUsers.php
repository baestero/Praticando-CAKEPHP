<div class="sorts">
  <span class="sort">Organizar por:</span>

  <span class="sort">
    <?php echo $this->Paginator->sort('firstName', 'Nome'); ?>
  </span>

  <span class="sort">
    <?php echo $this->Paginator->sort('lastName', 'SobreNome'); ?>
  </span>
</div>
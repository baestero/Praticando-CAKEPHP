<?php

declare(strict_types=1);

namespace App\Controller;


class ProductController extends AppController
{
  public function show()
  {
    var_dump('product show' . ' ' .  $this->request->getParam('id'));
    die();
  }
}

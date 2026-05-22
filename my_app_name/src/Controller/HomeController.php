<?php

declare(strict_types=1);

namespace App\Controller;

class HomeController extends AppController
{
  public function index()
  {
    $name = 'Leonardo';
    $age = '27';

    $this->set(compact('name', 'age'));

    return $this->render('index', 'master');
  }
}

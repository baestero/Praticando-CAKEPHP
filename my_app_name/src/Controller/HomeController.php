<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class HomeController extends AppController
{
  public function index()
  {

    $connection = ConnectionManager::get('default');

    $prepare = $connection->prepare('SELECT * FROM users WHERE id > :id');
    $prepare->bindValue('id', 5);
    $prepare->execute();
    $users = $prepare->fetchAll('obj');


    $this->set(compact('users'));

    return $this->render('index', 'master');
  }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class HomeController extends AppController
{
  public function index()
  {

    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $query = $tableUsers->find()->contain(['Posts']);

    $users = $this->paginate($query, [
      'limit' => 15,
    ]);



    $this->set(compact('users'));

    $this->render('index', 'master');
  }
}

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
    $users = $tableUsers->find()
      ->limit(5)
      ->where(['id >' => 10])
      ->order('id desc');

    $userEntity = $tableUsers->newEmptyEntity();
    $userEntity->id = 22;
    $userEntity->firstName = 'Eduardo';
    $tableUsers->save($userEntity);


    $this->set(compact('users'));

    $this->render('index', 'master');
  }
}

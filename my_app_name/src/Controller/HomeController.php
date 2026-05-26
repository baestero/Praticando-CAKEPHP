<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class HomeController extends AppController
{
  public function index()
  {
    $tablePosts = TableRegistry::getTableLocator()->get('Posts');
    $posts = $tablePosts->find()->contain(['Users']);

    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $users = $tableUsers->find()->contain(['Posts']);

    $tableRoles = TableRegistry::getTableLocator()->get('Roles');
    $roles = $tableRoles->find()->contain(['Abilities']);


    $this->set(compact('users', 'posts', 'roles'));

    $this->render('index', 'master');
  }
}

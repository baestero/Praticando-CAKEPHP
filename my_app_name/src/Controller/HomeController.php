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

  public function add()
  {
    $tableUsers = TableRegistry::getTableLocator()->get('Users');
    $userEntity = $tableUsers->newEmptyEntity();

    if ($this->request->is('post')) {
      $userEntity = $tableUsers->patchEntity($userEntity, $this->request->getData());

      if ($tableUsers->save($userEntity)) {
        $this->Flash->success(__('Usuário Cadastrado com sucesso'));
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error(__('Usuário não foi cadastrado com sucesso'));
      }
    }

    $this->set(compact('userEntity'));

    $this->render('add', 'master');
  }
}

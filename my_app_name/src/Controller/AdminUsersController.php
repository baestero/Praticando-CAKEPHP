<?php

declare(strict_types=1);

namespace App\Controller;


class AdminUsersController extends AppController
{
  public function index()
  {
    var_dump('Admin Users Index');
    die();
  }
  public function show($arg1)
  {
    var_dump('List user get id:', $arg1);
    die();
  }
}

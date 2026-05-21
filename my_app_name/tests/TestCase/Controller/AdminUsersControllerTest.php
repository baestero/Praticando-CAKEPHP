<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AdminUsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AdminUsersController Test Case
 *
 * @uses \App\Controller\AdminUsersController
 */
class AdminUsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AdminUsers',
    ];
}

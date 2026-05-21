<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ClubeController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ClubeController Test Case
 *
 * @uses \App\Controller\ClubeController
 */
class ClubeControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Clube',
    ];
}

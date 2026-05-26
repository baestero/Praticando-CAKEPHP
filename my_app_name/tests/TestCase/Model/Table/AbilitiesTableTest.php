<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AbilitiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AbilitiesTable Test Case
 */
class AbilitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AbilitiesTable
     */
    protected $Abilities;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Abilities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Abilities') ? [] : ['className' => AbilitiesTable::class];
        $this->Abilities = $this->getTableLocator()->get('Abilities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Abilities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AbilitiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

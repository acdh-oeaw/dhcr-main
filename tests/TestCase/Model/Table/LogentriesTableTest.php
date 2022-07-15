<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogentriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogentriesTable Test Case
 */
class LogentriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LogentriesTable
     */
    protected $Logentries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Logentries',
        'app.LogentryCodes',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Logentries') ? [] : ['className' => LogentriesTable::class];
        $this->Logentries = $this->getTableLocator()->get('Logentries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Logentries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LogentriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LogentriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

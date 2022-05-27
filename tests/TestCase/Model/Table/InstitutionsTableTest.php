<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstitutionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstitutionsTable Test Case
 */
class InstitutionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InstitutionsTable
     */
    protected $Institutions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Institutions',
        'app.Cities',
        'app.Countries',
        'app.Courses',
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
        $config = $this->getTableLocator()->exists('Institutions') ? [] : ['className' => InstitutionsTable::class];
        $this->Institutions = $this->getTableLocator()->get('Institutions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Institutions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InstitutionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\InstitutionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

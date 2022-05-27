<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CitiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CitiesTable Test Case
 */
class CitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CitiesTable
     */
    protected $Cities;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cities',
        'app.Countries',
        'app.Courses',
        'app.Institutions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cities') ? [] : ['className' => CitiesTable::class];
        $this->Cities = $this->getTableLocator()->get('Cities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CitiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CitiesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

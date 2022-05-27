<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LanguagesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LanguagesTable Test Case
 */
class LanguagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LanguagesTable
     */
    protected $Languages;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Languages',
        'app.Courses',
        'app.Subscriptions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Languages') ? [] : ['className' => LanguagesTable::class];
        $this->Languages = $this->getTableLocator()->get('Languages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Languages);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LanguagesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

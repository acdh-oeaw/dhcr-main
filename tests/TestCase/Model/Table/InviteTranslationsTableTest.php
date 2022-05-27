<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InviteTranslationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InviteTranslationsTable Test Case
 */
class InviteTranslationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InviteTranslationsTable
     */
    protected $InviteTranslations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.InviteTranslations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InviteTranslations') ? [] : ['className' => InviteTranslationsTable::class];
        $this->InviteTranslations = $this->getTableLocator()->get('InviteTranslations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->InviteTranslations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InviteTranslationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

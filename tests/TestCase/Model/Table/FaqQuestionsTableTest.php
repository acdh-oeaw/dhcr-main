<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaqQuestionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaqQuestionsTable Test Case
 */
class FaqQuestionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaqQuestionsTable
     */
    protected $FaqQuestions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.FaqQuestions',
        'app.FaqCategories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FaqQuestions') ? [] : ['className' => FaqQuestionsTable::class];
        $this->FaqQuestions = $this->getTableLocator()->get('FaqQuestions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FaqQuestions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FaqQuestionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\FaqQuestionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

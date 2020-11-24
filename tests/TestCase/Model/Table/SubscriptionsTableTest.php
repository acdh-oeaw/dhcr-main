<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubscriptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubscriptionsTable Test Case
 */
class SubscriptionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SubscriptionsTable
     */
    public $SubscriptionsTable;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Subscriptions',
        'app.Notifications',
        'app.Disciplines',
        'app.Languages',
        'app.CourseTypes',
        'app.Countries',
        'app.TadirahTechniques',
        'app.TadirahObjects',
        'app.DisciplinesSubscriptions',
        'app.CountriesSubscriptions',
        'app.CourseTypesSubscriptions',
        'app.LanguagesSubscriptions',
        'app.SubscriptionsTadirahTechniques',
        'app.SubscriptionsTadirahObjects'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Subscriptions') ? [] : ['className' => SubscriptionsTable::class];
        $this->SubscriptionsTable = TableRegistry::getTableLocator()->get('Subscriptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SubscriptionsTable);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testGetNewCourses() {
        $result = $this->SubscriptionsTable->getNewCourses();
        debug($result);
    }
}

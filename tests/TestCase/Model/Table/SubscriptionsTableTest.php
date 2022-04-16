<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubscriptionsTable;
use Cake\Core\Configure;
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
        'app.SubscriptionsTadirahObjects',
        'app.Courses',
        'app.CoursesDisciplines',
        'app.CoursesTadirahObjects',
        'app.CoursesTadirahTechniques',
        'app.Institutions',
        'app.Cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
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
    public function tearDown(): void
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



    public function testGetSubscriptions()
    {
        $result = $this->SubscriptionsTable->getSubscriptions();
        // the other test record should be rejected by the method's filter criteria 'confirmed'
        $this->assertEquals(4, count($result));
        foreach ($result as $row) {
            $this->assertArrayHasKey('confirmed', $row);
            $this->assertTrue($row->confirmed);
            $this->assertArrayHasKey('course_types', $row);
            $this->assertArrayHasKey('countries', $row);
            $this->assertArrayHasKey('languages', $row);
            $this->assertArrayHasKey('tadirah_techniques', $row);
            $this->assertArrayHasKey('tadirah_objects', $row);
            $this->assertArrayHasKey('disciplines', $row);
            // courses will be filtered over notifications already being sent
            $this->assertArrayHasKey('notifications', $row);
        }
    }


    // test only the loop body of processSubscriptions
    public function testProcessSubscription()
    {
        $options = ['contain' => $this->SubscriptionsTable::$containments];

        $subscription = $this->SubscriptionsTable->get(1, $options);    // has notification on course 1, course 2 deleted, course 3 & 4 not online,
        $result = $this->SubscriptionsTable->processSubscription($subscription);
        $this->assertTrue($result === 0);

        $subscription = $this->SubscriptionsTable->get(2, $options);    // not confirmed
        $result = $this->SubscriptionsTable->processSubscription($subscription);
        $this->assertTrue($result === false);

        $subscription = $this->SubscriptionsTable->get(3, $options);    // notification on course 1
        $this->assertEquals(2, count($subscription->languages));
        $result = $this->SubscriptionsTable->processSubscription($subscription);
        $this->assertTrue($result === 2);
    }



    public function testSendNotification()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

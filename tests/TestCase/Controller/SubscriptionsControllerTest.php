<?php

namespace App\Test\TestCase\Controller;

use App\Controller\SubscriptionsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\SubscriptionsController Test Case
 *
 * @uses \App\Controller\SubscriptionsController
 */
class SubscriptionsControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
        'app.TadirahObjects',
        'app.TadirahTechniques',
        'app.DisciplinesSubscriptions',
        'app.LanguagesSubscriptions',
        'app.CourseTypesSubscriptions',
        'app.CountriesSubscriptions',
        'app.SubscriptionsTadirahObjects',
        'app.SubscriptionsTadirahTechniques',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

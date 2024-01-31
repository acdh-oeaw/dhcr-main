<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CoursesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CoursesTable Test Case
 */
class CoursesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CoursesTable
     */
    public $Courses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Courses',
        'app.Users',
        'app.DeletionReasons',
        'app.Countries',
        'app.Cities',
        'app.Institutions',
        'app.CourseParentTypes',
        'app.CourseTypes',
        'app.Languages',
        'app.CourseDurationUnits',
        'app.Notifications',
        'app.Disciplines',
        'app.TadirahActivities',
        'app.TadirahObjects',
        'app.TadirahTechniques',
        'app.Notifications',
        'app.CoursesDisciplines',
        'app.CoursesTadirahObjects',
        'app.CoursesTadirahTechniques'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Courses') ? [] : ['className' => CoursesTable::class];
        $this->Courses = TableRegistry::getTableLocator()->get('Courses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Courses);

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



    public function testGetFilter()
    {
        $SubscriptionsTable = TableRegistry::getTableLocator()->get('Subscriptions');
        $subscriptions = $SubscriptionsTable->getSubscriptions();
        foreach ($subscriptions as $row) {
            $options = $this->Courses->getFilter($row);

            if ($row['online_course'] !== null)
                $this->assertArrayHasKey('Courses.online_course', $options['conditions']);
            else
                $this->assertArrayNotHasKey('Courses.online_course', $options['conditions']);

            if ($row['notifications'])
                $this->assertArrayHasKey('Courses.id NOT IN', $options['conditions']);
            else
                $this->assertArrayNotHasKey('Courses.id NOT IN', $options['conditions']);
        }
    }
}

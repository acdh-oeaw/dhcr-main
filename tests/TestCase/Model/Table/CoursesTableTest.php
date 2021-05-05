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
        'app.Subscriptions',
        'app.Notifications',
        'app.DisciplinesSubscriptions',
        'app.CountriesSubscriptions',
        'app.CourseTypesSubscriptions',
        'app.LanguagesSubscriptions',
        'app.SubscriptionsTadirahTechniques',
        'app.SubscriptionsTadirahObjects',
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



    public function testGetFilter() {
        $SubscriptionsTable = TableRegistry::getTableLocator()->get('Subscriptions');
        $subscriptions = $SubscriptionsTable->getSubscriptions();
        foreach($subscriptions as $row) {
            $options = $this->Courses->getFilter($row);

            if($row['online_course'] !== null)
                $this->assertArrayHasKey('Courses.online_course', $options['conditions']);
            else
                $this->assertArrayNotHasKey('Courses.online_course', $options['conditions']);

            if($row['notifications'])
                $this->assertArrayHasKey('Courses.id NOT IN', $options['conditions']);
            else
                $this->assertArrayNotHasKey('Courses.id NOT IN', $options['conditions']);
        }
    }



    public function testGetSubscriptionCourses() {
        $SubscriptionsTable = TableRegistry::getTableLocator()->get('Subscriptions');
        $subscription = $SubscriptionsTable->get(1,
            ['contain' => $SubscriptionsTable::$containments]);
        $result = $this->Courses->getSubscriptionCourses($subscription);
        // the first subscription has all filters set, should find first course,
        // but there's already a notification for course id 1
        $this->assertEquals(0, count($result));

        $subscription = $SubscriptionsTable->get(2,
            ['contain' => $SubscriptionsTable::$containments]);
        $result = $this->Courses->getSubscriptionCourses($subscription);
        // second subscription will find course id 3
        // has discipline 1 set as filter
        $this->assertEquals(false, $result[0]['online_course']);
        $this->assertEquals(1, count($result)); // will not get course 4 which has no tags
        $this->assertEquals(false, $result[0]['deleted']);
        $this->assertTrue($result[0]['updated'] > $subscription['created']);
        $this->assertEquals(1, count($result[0]['disciplines']));
        // add more tests with advanced criteria here...

        $subscription = $SubscriptionsTable->get(4,
            ['contain' => $SubscriptionsTable::$containments]);
        $result = $this->Courses->getSubscriptionCourses($subscription);
        // subscription 4 has online_course = null, no filters at all
        $this->assertEquals(1, $result[0]['id']);
        // course 2 is deleted
        $this->assertEquals(3, $result[1]['id']);
        $this->assertEquals(4, $result[2]['id']);
    }
}

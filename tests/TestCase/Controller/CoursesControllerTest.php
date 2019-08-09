<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CoursesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CoursesController Test Case
 */
class CoursesControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
        'app.Disciplines',
        'app.TadirahObjects',
        'app.TadirahTechniques',
        'app.CoursesDisciplines',
        'app.CoursesTadirahObjects',
        'app.CoursesTadirahTechniques'
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

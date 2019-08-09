<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseParentTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseParentTypesTable Test Case
 */
class CourseParentTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseParentTypesTable
     */
    public $CourseParentTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CourseParentTypes',
        'app.CourseParentTypes',
        'app.Courses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseParentTypes') ? [] : ['className' => CourseParentTypesTable::class];
        $this->CourseParentTypes = TableRegistry::getTableLocator()->get('CourseParentTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseParentTypes);

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
    
    
    public function testGetCleanQuery() {
        $query = [
            'foo' => 'bar',
            'sort_count' => ''
        ];
        $query = $this->CourseParentTypes->getCleanQuery($query);
        $this->assertArrayNotHasKey('foo', $query);
        $this->assertArrayHasKey('sort_count', $query);
    }
    
    
    public function testGetFilter() {
        $this->CourseParentTypes->query = [
            'sort_count' => ''
        ];
        $query = $this->CourseParentTypes->getFilter();
        $this->assertArrayHasKey('sort_count', $query);
        $this->assertTrue($query['sort_count']);
        $this->assertArrayHasKey('course_count', $query);
        $this->assertTrue($query['course_count']);
    }
    
    
    public function testGetCourseParentType() {
        $record = $this->CourseParentTypes->getCourseParentType(1);
        $this->assertArrayHasKey('id', $record);
        $this->assertArrayHasKey('name', $record);
        $this->assertArrayHasKey('course_count', $record);
    }
    
    
    public function testGetCourseParentTypes() {
        $this->CourseParentTypes->query = [];
        $records = $this->CourseParentTypes->getCourseParentTypes();
        foreach($records as $record) {
            $this->assertArrayHasKey('id', $record);
            $this->assertArrayHasKey('name', $record);
            // we're dealing with an object here
            $this->assertObjectNotHasAttribute('course_count', $record);
        }
        $this->CourseParentTypes->query = ['course_count' => true];
        $records = $this->CourseParentTypes->getCourseParentTypes();
        foreach($records as $record) {
            $this->assertNotEmpty($record['course_count']);
        }
        $this->CourseParentTypes->query = ['sort_count' => true];
        $records = $this->CourseParentTypes->getCourseParentTypes();
        $last = null;
        foreach($records as $record) {
            if($last !== null)
                $this->assertTrue($last > $record['course_count']);
            $last = $record['course_count'];
        }
    }
    
}

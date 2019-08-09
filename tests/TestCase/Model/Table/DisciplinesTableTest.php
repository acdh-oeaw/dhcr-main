<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DisciplinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DisciplinesTable Test Case
 */
class DisciplinesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DisciplinesTable
     */
    public $Disciplines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Disciplines',
        'app.Courses',
        'app.CoursesDisciplines'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Disciplines') ? [] : ['className' => DisciplinesTable::class];
        $this->Disciplines = TableRegistry::getTableLocator()->get('Disciplines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Disciplines);

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
        $query = $this->Disciplines->getCleanQuery($query);
        $this->assertArrayNotHasKey('foo', $query);
        $this->assertArrayHasKey('sort_count', $query);
    }
    
    
    public function testGetFilter() {
        $this->Disciplines->query = [
            'sort_count' => ''
        ];
        $query = $this->Disciplines->getFilter();
        $this->assertArrayHasKey('sort_count', $query);
        $this->assertTrue($query['sort_count']);
        $this->assertArrayHasKey('course_count', $query);
        $this->assertTrue($query['course_count']);
    }
    
    
    public function testGetDiscipline() {
        $record = $this->Disciplines->getDiscipline(1);
        $this->assertArrayHasKey('id', $record);
        $this->assertArrayHasKey('name', $record);
        $this->assertArrayHasKey('course_count', $record);
    }
    
    
    public function testGetDisciplines() {
        $this->Disciplines->query = [];
        $records = $this->Disciplines->getDisciplines();
        foreach($records as $record) {
            $this->assertArrayHasKey('id', $record);
            $this->assertArrayHasKey('name', $record);
            // we're dealing with an object here
            $this->assertObjectNotHasAttribute('course_count', $record);
        }
        $this->Disciplines->query = ['course_count' => true];
        $records = $this->Disciplines->getDisciplines();
        foreach($records as $record) {
            $this->assertNotEmpty($record['course_count']);
        }
        $this->Disciplines->query = ['sort_count' => true];
        $records = $this->Disciplines->getDisciplines();
        $last = null;
        foreach($records as $record) {
            if($last !== null)
                $this->assertTrue($last > $record['course_count']);
            $last = $record['course_count'];
        }
    }
    
}

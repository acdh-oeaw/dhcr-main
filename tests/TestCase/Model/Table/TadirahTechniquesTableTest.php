<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TadirahTechniquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TadirahTechniquesTable Test Case
 */
class TadirahTechniquesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TadirahTechniquesTable
     */
    public $TadirahTechniques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TadirahTechniques',
        'app.Courses',
        'app.CoursesTadirahTechniques'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TadirahTechniques') ? [] : ['className' => TadirahTechniquesTable::class];
        $this->TadirahTechniques = TableRegistry::getTableLocator()->get('TadirahTechniques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TadirahTechniques);

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
        $query = $this->TadirahTechniques->getCleanQuery($query);
        $this->assertArrayNotHasKey('foo', $query);
        $this->assertArrayHasKey('sort_count', $query);
    }
    
    
    public function testGetFilter() {
        $this->TadirahTechniques->query = [
            'sort_count' => ''
        ];
        $query = $this->TadirahTechniques->getFilter();
        $this->assertArrayHasKey('sort_count', $query);
        $this->assertTrue($query['sort_count']);
        $this->assertArrayHasKey('course_count', $query);
        $this->assertTrue($query['course_count']);
    }
    
    
    public function testGetTadirahTechnique() {
        $record = $this->TadirahTechniques->getTadirahTechnique(1);
        $this->assertArrayHasKey('id', $record);
        $this->assertArrayHasKey('name', $record);
        $this->assertArrayHasKey('course_count', $record);
    }
    
    
    public function testGetTadirahTechniques() {
        $this->TadirahTechniques->query = [];
        $records = $this->TadirahTechniques->getTadirahTechniques();
        foreach($records as $record) {
            $this->assertArrayHasKey('id', $record);
            $this->assertArrayHasKey('name', $record);
            // we're dealing with an object here
            $this->assertObjectNotHasAttribute('course_count', $record);
        }
        $this->TadirahTechniques->query = ['course_count' => true];
        $records = $this->TadirahTechniques->getTadirahTechniques();
        foreach($records as $record) {
            $this->assertNotEmpty($record['course_count']);
        }
        $this->TadirahTechniques->query = ['sort_count' => true];
        $records = $this->TadirahTechniques->getTadirahTechniques();
        $last = null;
        foreach($records as $record) {
            if($last !== null)
                $this->assertTrue($last > $record['course_count']);
            $last = $record['course_count'];
        }
    }
    
}

<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LanguagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LanguagesTable Test Case
 */
class LanguagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LanguagesTable
     */
    public $Languages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Languages',
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
        $config = TableRegistry::getTableLocator()->exists('Languages') ? [] : ['className' => LanguagesTable::class];
        $this->Languages = TableRegistry::getTableLocator()->get('Languages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Languages);

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
        $query = $this->Languages->getCleanQuery($query);
        $this->assertArrayNotHasKey('foo', $query);
        $this->assertArrayHasKey('sort_count', $query);
    }
    
    
    public function testGetFilter() {
        $this->Languages->query = [
            'sort_count' => ''
        ];
        $query = $this->Languages->getFilter();
        $this->assertArrayHasKey('sort_count', $query);
        $this->assertTrue($query['sort_count']);
        $this->assertArrayHasKey('course_count', $query);
        $this->assertTrue($query['course_count']);
    }
    
    
    public function testGetLanguage() {
        $record = $this->Languages->getLanguage(1);
        $this->assertArrayHasKey('id', $record);
        $this->assertArrayHasKey('name', $record);
        $this->assertArrayHasKey('course_count', $record);
    }
    
    
    public function testGetLanguages() {
        $this->Languages->query = [];
        $records = $this->Languages->getLanguages();
        foreach($records as $record) {
            $this->assertArrayHasKey('id', $record);
            $this->assertArrayHasKey('name', $record);
            // we're dealing with an object here
            $this->assertObjectNotHasAttribute('course_count', $record);
        }
        $this->Languages->query = ['course_count' => true];
        $records = $this->Languages->getLanguages();
        foreach($records as $record) {
            $this->assertNotEmpty($record['course_count']);
        }
        $this->Languages->query = ['sort_count' => true];
        $records = $this->Languages->getLanguages();
        $last = null;
        foreach($records as $record) {
            if($last !== null)
                $this->assertTrue($last > $record['course_count']);
            $last = $record['course_count'];
        }
    }
    
}

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
        'app.Disciplines',
        'app.TadirahObjects',
        'app.TadirahTechniques',
		'app.CoursesTadirahObjects',
		'app.CoursesTadirahTechniques',
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
        $config = TableRegistry::getTableLocator()->exists('Courses') ? [] : ['className' => CoursesTable::class];
        $this->Courses = TableRegistry::getTableLocator()->get('Courses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
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
    
    
    public function testGetCleanQuery() {
		$this->Courses->query = [
			'foo' => 'bar',
			'discipline_id' => '1,2, 3 , 4'
		];
		$query = $this->Courses->getCleanQuery();
		$this->assertArrayNotHasKey('foo', $query);
		$this->assertArrayHasKey('discipline_id', $query);
		$this->assertTrue(is_array($query['discipline_id']));
	}
    
    
    public function testGetFilter() {
		$this->Courses->query = [];
		// set some values for testing
		foreach($this->Courses->allowedFilters as $key) {
			switch($key) {
				case 'recent':
					$this->Courses->query[$key] = ''; break;
				default:
					// should be some numeric value of a foreign key, delivered as string!
					$this->Courses->query[$key] = '3';
			}
		}
    	$conditions = $this->Courses->getFilter();
		
    	$this->assertArrayHasKey('Courses.active', $conditions);
		$this->assertEquals($conditions['Courses.active'], true);
		
    	foreach($this->Courses->allowedFilters as $key) {
    		switch($key) {
				case 'recent':
					$this->assertEquals($this->Courses->query['recent'], true);	// empty param 'recent' defaults to true
					$this->assertArrayHasKey('Courses.updated >', $conditions);
					$this->assertFalse($conditions['Courses.deleted']);
					// no test for date
					break;
				case 'start_date':
					$this->assertArrayHasKey('Courses.created >=', $conditions);
					break;
				case 'end_date':
					$this->assertArrayHasKey('Courses.updated <=', $conditions);
					break;
				case 'sort_asc':
					// this should not go into the conditions array!
					$this->assertArrayNotHasKey('Courses.sort_asc', $conditions);
					break;
				case 'sort_desc':
					$this->assertArrayNotHasKey('Courses.sort_desc', $conditions);
					break;
    			default:
					$this->assertArrayHasKey('Courses.'.$key, $conditions);
					$this->assertEquals($conditions['Courses.'.$key], 3);
			}
		}
	}
	
	
	public function testGetJoins() {
		$this->Courses->query = [
			'discipline_id' => [],
			'tadirah_technique_id' => [3,4],
			'tadirah_object_id' => [2]
		];
		$joins = $this->Courses->getJoins();
		foreach($joins as $join) {
			$this->assertArrayHasKey('assoc', $join);
			$this->assertArrayHasKey('conditions', $join);
		}
	}
	
	
	public function testGetSorters() {
    	$this->Courses->query = [
    		'sort' => ['name','Cities.name:desc','Cities.foo']
		];
    	$sorters = $this->Courses->getSorters();
    	// allowed sort criteria should match existing fields from associations involved in the query
		// if no model is given, the default model 'Courses' should be assumed
		// ASC is the default sort direction
    	$this->assertArrayHasKey('Courses.name', $sorters);
    	$this->assertEquals('ASC', $sorters['Courses.name']);
    	$this->assertArrayHasKey('Cities.name', $sorters);
    	$this->assertEquals('DESC', $sorters['Cities.name']);
    	$this->assertArrayNotHasKey('Cities.foo', $sorters);
	}
	
	
	public function testGetResults() {
 		$query = [
 			'country_id' => '1',
			'discipline_id' => [1,2]
		];
    	$this->Courses->evaluateQuery($query);
    	$courses = $this->Courses->getResults();
    	
 		$this->assertNotEmpty($courses);
		
		$query = [
			'country_id' => '2',
			'discipline_id' => [1,2]
		];
		$this->Courses->evaluateQuery($query);
		$courses = $this->Courses->getResults();
		
		$this->assertEmpty($courses);
		
		$query = [
			'country_id' => '1',
			'discipline_id' => [3,2]
		];
		$this->Courses->evaluateQuery($query);
		$courses = $this->Courses->getResults();
		
		$this->assertEmpty($courses);
	}
	
	
	public function testCountResults() {
		$query = [
			'country_id' => '1',
			'discipline_id' => [1,2]
		];
		$this->Courses->evaluateQuery($query);
		$result = $this->Courses->countResults();
		
		$this->assertEquals(1, $result);
	}
}

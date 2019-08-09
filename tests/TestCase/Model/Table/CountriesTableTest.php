<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CountriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CountriesTable Test Case
 */
class CountriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CountriesTable
     */
    public $Countries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Countries',
        'app.Cities',
        'app.Courses',
        'app.Institutions',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Countries') ? [] : ['className' => CountriesTable::class];
        $this->Countries = TableRegistry::getTableLocator()->get('Countries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Countries);

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
		$query = $this->Countries->getCleanQuery($query);
		$this->assertArrayNotHasKey('foo', $query);
		$this->assertArrayHasKey('sort_count', $query);
	}
	
	
	public function testGetFilter() {
		$this->Countries->query = [
			'sort_count' => ''
		];
		$query = $this->Countries->getFilter();
		$this->assertArrayHasKey('sort_count', $query);
		$this->assertTrue($query['sort_count']);
		$this->assertArrayHasKey('course_count', $query);
		$this->assertTrue($query['course_count']);
	}
    
    
    public function testGetCountry() {
    	$country = $this->Countries->getCountry(1);
    	$this->assertArrayHasKey('course_count', $country);
	}
	
	
	public function testGetCountries() {
 		$this->Countries->query = ['course_count' => true];
    	$countries = $this->Countries->getCountries();
 		foreach($countries as $country) {
 			$this->assertNotEmpty($country['course_count']);
		}
		$this->Countries->query = [];
		$countries = $this->Countries->getCountries();
 		foreach($countries as $country) {
			// we're dealing with an object here
			$this->assertObjectNotHasAttribute('course_count', $country);
		}
		$this->Countries->query = ['course_count' => true,'sort_count' => true];
		$countries = $this->Countries->getCountries();
		$last = null;
		foreach($countries as $country) {
			if($last !== null)
				$this->assertTrue($last > $country['course_count']);
			$last = $country['course_count'];
		}
	}
 
 
 
}

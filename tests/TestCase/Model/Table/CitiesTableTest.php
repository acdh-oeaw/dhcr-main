<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CitiesTable Test Case
 */
class CitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CitiesTable
     */
    public $Cities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Cities',
        'app.Countries',
        'app.Courses',
        'app.Institutions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cities') ? [] : ['className' => CitiesTable::class];
        $this->Cities = TableRegistry::getTableLocator()->get('Cities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cities);

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
		$query = [
			'foo' => 'bar',
			'sort_count' => '',
			'group' => true,
			'country_id' => '3'
		];
		$query = $this->Cities->getCleanQuery($query);
		$this->assertArrayNotHasKey('foo', $query);
		$this->assertArrayHasKey('sort_count', $query);
		$this->assertArrayHasKey('group', $query);
		$this->assertArrayHasKey('country_id', $query);
	}
	
	
	public function testGetFilter() {
		$this->Cities->query = [
			'sort_count' => ''
		];
		$query = $this->Cities->getFilter();
		$this->assertArrayHasKey('sort_count', $query);
		$this->assertTrue($query['sort_count']);
		$this->assertArrayHasKey('course_count', $query);
		$this->assertTrue($query['course_count']);
		
		$this->Cities->query = ['group' => ''];
		$query = $this->Cities->getFilter();
		$this->assertArrayHasKey('group', $query);
		$this->assertTrue($query['group']);
		
		$this->Cities->query = ['group' => '', 'country_id' => '2'];
		$query = $this->Cities->getFilter();
		$this->assertArrayNotHasKey('group', $query);
		$this->assertArrayHasKey('country_id', $query);
		$this->assertTrue(ctype_digit($query['country_id']));
		
		$this->Cities->query = ['group' => '', 'country_id' => '1,2'];
		$query = $this->Cities->getFilter();
		$this->assertArrayHasKey('group', $query);
		$this->assertArrayNotHasKey('country_id', $query);
	}
	
	
	public function testGetCity() {
		$city = $this->Cities->getCity(1);
		$this->__testCity($city);
	}
	
	private function __testCity($city = []) {
		$this->assertArrayHasKey('course_count', $city);
		$this->assertArrayHasKey('id', $city);
		$this->assertArrayHasKey('name', $city);
		$this->assertArrayHasKey('country_id', $city);
		$this->assertArrayHasKey('country', $city);
		$this->assertArrayHasKey('name', $city['country']);
	}
	
	
	public function testGetCities() {
		$this->Cities->query = ['course_count' => true];
    	$cities = $this->Cities->getCities();
		foreach($cities as $city) {
			$this->assertArrayHasKey('course_count', $city);
			$this->__testCity($city);
		}
		$this->Cities->query = [];
		$cities = $this->Cities->getCities();
		foreach($cities as $city) {
			// we retrieve an object here
			$this->assertObjectNotHasAttribute('course_count', $city);
		}
		$this->Cities->query = ['course_count' => true,'sort_count' => true];
		$cities = $this->Cities->getCities();
		$last = null;
		foreach($cities as $city) {
			if($last !== null)
				$this->assertTrue($last > $city['course_count']);
			$last = $city['course_count'];
		}
		$this->Cities->query = ['group' => true, 'country_id' => '1'];
		$cities = $this->Cities->getCities();
		foreach($cities as $country => $c_cities) {
			$this->assertTrue($country === 'Lorem ipsum dolor sit amet');
			$this->assertTrue(is_array($c_cities));
			foreach($c_cities as $key => $city) {
				$this->assertTrue(is_integer($key));
				$this->assertNotEmpty($city['name']);
				$this->assertNotEmpty($city['id']);
			}
		}
	}
 
}

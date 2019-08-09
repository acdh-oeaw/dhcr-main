<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseDurationUnitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseDurationUnitsTable Test Case
 */
class CourseDurationUnitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseDurationUnitsTable
     */
    public $CourseDurationUnits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CourseDurationUnits',
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
        $config = TableRegistry::getTableLocator()->exists('CourseDurationUnits') ? [] : ['className' => CourseDurationUnitsTable::class];
        $this->CourseDurationUnits = TableRegistry::getTableLocator()->get('CourseDurationUnits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseDurationUnits);

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
	
	
	
	
	public function testGetCourseDurationUnit() {
		$record = $this->CourseDurationUnits->getCourseDurationUnit(1);
		$this->assertArrayHasKey('id', $record);
		$this->assertArrayHasKey('name', $record);
	}
	
	
	public function testGetCourseDurationUnits() {
		$this->CourseDurationUnits->query = [];
		$records = $this->CourseDurationUnits->getCourseDurationUnits();
		foreach($records as $record) {
			$this->assertArrayHasKey('id', $record);
			$this->assertArrayHasKey('name', $record);
		}
	}
 
}

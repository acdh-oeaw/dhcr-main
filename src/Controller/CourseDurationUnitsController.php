<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseDurationUnits Controller
 *
 * @property \App\Model\Table\CourseDurationUnitsTable $CourseDurationUnits
 *
 * @method \App\Model\Entity\CourseDurationUnit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseDurationUnitsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function index() {
		$duration_units = $this->CourseDurationUnits->getCourseDurationUnits();
		
		$this->set('duration_units', $duration_units);
		$this->set('_serialize', 'duration_units');
	}
	
	
	
	
	
	/**
	 * View method
	 *
	 * @param string|null $id Country id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$duration_unit = $this->CourseDurationUnits->getCourseDurationUnit($id);
		
		$this->set('duration_unit', $duration_unit);
		$this->set('_serialize', 'duration_unit');
	}
}

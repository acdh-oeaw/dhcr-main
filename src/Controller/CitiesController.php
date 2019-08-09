<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
		$this->Cities->evaluateQuery($this->request->getQuery());
	
		$cities = $this->Cities->getCities();
	
		$this->set('cities', $cities);
		$this->set('_serialize', 'cities');
    }

    /**
     * View method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $city = $this->Cities->getCity($id);

        $this->set('city', $city);
		$this->set('_serialize', 'city');
    }

   
}

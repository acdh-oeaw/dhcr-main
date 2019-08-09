<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Countries Controller
 *
 * @property \App\Model\Table\CountriesTable $Countries
 *
 * @method \App\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CountriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
		$this->Countries->evaluateQuery($this->request->getQuery());
    	
    	$countries = $this->Countries->getCountries();
	
		$this->set('countries', $countries);
		$this->set('_serialize', 'countries');
	}
	
	
    /**
     * View method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $country = $this->Countries->getCountry($id);

        $this->set('country', $country);
        $this->set('_serialize', 'country');
    }

    
}

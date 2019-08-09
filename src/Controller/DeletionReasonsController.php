<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DeletionReasons Controller
 *
 * @property \App\Model\Table\DeletionReasonsTable $DeletionReasons
 *
 * @method \App\Model\Entity\DeletionReason[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeletionReasonsController extends AppController
{
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function index() {
		$deletion_reasons = $this->DeletionReasons->getDeletionReasons();
		
		$this->set('deletion_reasons', $deletion_reasons);
		$this->set('_serialize', 'deletion_reasons');
	}
	
	
	
	
	
	/**
	 * View method
	 *
	 * @param string|null $id Country id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$deletion_reasons = $this->DeletionReasons->getDeletionReason($id);
		
		$this->set('deletion_reasons', $deletion_reasons);
		$this->set('_serialize', 'deletion_reasons');
	}
}

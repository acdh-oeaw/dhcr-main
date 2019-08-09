<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TadirahObjects Controller
 *
 * @property \App\Model\Table\TadirahObjectsTable $TadirahObjects
 *
 * @method \App\Model\Entity\TadirahObject[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TadirahObjectsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->TadirahObjects->evaluateQuery($this->request->getQuery());
        
        $tadirah_objects = $this->TadirahObjects->getTadirahObjects();
        
        $this->set('tadirah_objects', $tadirah_objects);
        $this->set('_serialize', 'tadirah_objects');
    }
    
    
    /**
     * View method
     *
     * @param string|null $id TadirahObject id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $tadirah_object = $this->TadirahObjects->getTadirahObject($id);
        
        $this->set('tadirah_object', $tadirah_object);
        $this->set('_serialize', 'tadirah_object');
    }
}

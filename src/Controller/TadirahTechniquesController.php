<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TadirahTechniques Controller
 *
 * @property \App\Model\Table\TadirahTechniquesTable $TadirahTechniques
 *
 * @method \App\Model\Entity\TadirahTechnique[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TadirahTechniquesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->TadirahTechniques->evaluateQuery($this->request->getQuery());
        
        $tadirah_techniques = $this->TadirahTechniques->getTadirahTechniques();
        
        $this->set('tadirah_techniques', $tadirah_techniques);
        $this->set('_serialize', 'tadirah_techniques');
    }
    
    
    /**
     * View method
     *
     * @param string|null $id TadirahTechnique id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $tadirah_technique = $this->TadirahTechniques->getTadirahTechnique($id);
        
        $this->set('tadirah_technique', $tadirah_technique);
        $this->set('_serialize', 'tadirah_technique');
    }
}

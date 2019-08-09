<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Disciplines Controller
 *
 * @property \App\Model\Table\DisciplinesTable $Disciplines
 *
 * @method \App\Model\Entity\Discipline[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DisciplinesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->Disciplines->evaluateQuery($this->request->getQuery());
        
        $disciplines = $this->Disciplines->getDisciplines();
        
        $this->set('disciplines', $disciplines);
        $this->set('_serialize', 'disciplines');
    }
    
    
    /**
     * View method
     *
     * @param string|null $id Discipline id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $discipline = $this->Disciplines->getDiscipline($id);
        
        $this->set('discipline', $discipline);
        $this->set('_serialize', 'discipline');
    }
}

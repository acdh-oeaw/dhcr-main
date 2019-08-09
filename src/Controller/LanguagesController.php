<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Languages Controller
 *
 * @property \App\Model\Table\LanguagesTable $Languages
 *
 * @method \App\Model\Entity\Language[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LanguagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->Languages->evaluateQuery($this->request->getQuery());
        
        $languages = $this->Languages->getLanguages();
        
        $this->set('languages', $languages);
        $this->set('_serialize', 'languages');
    }
    
    
    /**
     * View method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $language = $this->Languages->getLanguage($id);
        
        $this->set('language', $language);
        $this->set('_serialize', 'language');
    }
}

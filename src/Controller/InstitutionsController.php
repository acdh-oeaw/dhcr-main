<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Institutions Controller
 *
 * @property \App\Model\Table\InstitutionsTable $Institutions
 * @method \App\Model\Entity\Institution[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstitutionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities', 'Countries'],
        ];
        $institutions = $this->paginate($this->Institutions);

        $this->set(compact('institutions'));
    }

    /**
     * View method
     *
     * @param string|null $id Institution id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $institution = $this->Institutions->get($id, [
            'contain' => ['Cities', 'Countries', 'Courses', 'Users'],
        ]);

        $this->set(compact('institution'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $institution = $this->Institutions->newEmptyEntity();
        if ($this->request->is('post')) {
            $institution = $this->Institutions->patchEntity($institution, $this->request->getData());
            if ($this->Institutions->save($institution)) {
                $this->Flash->success(__('The institution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The institution could not be saved. Please, try again.'));
        }

        $cities = $this->Institutions->Cities->find('list', ['order' => 'Cities.name asc']);
        $countries = $this->Institutions->Countries->find('list', ['order' => 'Countries.name asc']);
        $this->set(compact('institution', 'cities', 'countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Institution id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $institution = $this->Institutions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $institution = $this->Institutions->patchEntity($institution, $this->request->getData());
            if ($this->Institutions->save($institution)) {
                $this->Flash->success(__('The institution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The institution could not be saved. Please, try again.'));
        }
        $cities = $this->Institutions->Cities->find('list', ['limit' => 200]);
        $countries = $this->Institutions->Countries->find('list', ['limit' => 200]);
        $this->set(compact('institution', 'cities', 'countries'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Institution id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $institution = $this->Institutions->get($id);
        if ($this->Institutions->delete($institution)) {
            $this->Flash->success(__('The institution has been deleted.'));
        } else {
            $this->Flash->error(__('The institution could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

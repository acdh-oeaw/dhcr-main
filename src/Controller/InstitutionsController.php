<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class InstitutionsController extends AppController
{
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('contributors');
    }

    public function index()
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Institutions';
        $breadcrumControllers[1] = 'Institutions';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->paginate = ['contain' => ['Cities', 'Countries']];
        $institutions = $this->paginate($this->Institutions);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('institutions'));
    }

    public function view($id = null)
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Institutions';
        $breadcrumControllers[1] = 'Institutions';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Institution Details';
        $breadcrumControllers[2] = 'Institutions';
        $breadcrumActions[2] = 'view';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $institution = $this->Institutions->get($id, ['contain' => ['Cities', 'Countries']]);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('institution'));
    }
    public function add()
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Institutions';
        $breadcrumControllers[1] = 'Institutions';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Add Institution';
        $breadcrumControllers[2] = 'Institutions';
        $breadcrumActions[2] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
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
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('institution', 'cities', 'countries'));
    }

    public function edit($id = null)
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Institutions';
        $breadcrumControllers[1] = 'Institutions';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Edit Institution';
        $breadcrumControllers[2] = 'Institutions';
        $breadcrumActions[2] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $institution = $this->Institutions->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $institution = $this->Institutions->patchEntity($institution, $this->request->getData());
            if ($this->Institutions->save($institution)) {
                $this->Flash->success(__('The institution has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The institution could not be saved. Please, try again.'));
        }
        $cities = $this->Institutions->Cities->find('list', ['order' => 'Cities.name asc']);
        $countries = $this->Institutions->Countries->find('list', ['order' => 'Countries.name asc']);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('institution', 'cities', 'countries'));
    }
}
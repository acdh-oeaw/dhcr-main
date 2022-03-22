<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class CitiesController extends AppController
{
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('contributors');
    }

    public function index()
    {
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Cities';
        $breadcrumControllers[1] = 'Cities';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $cities = $this->paginate($this->Cities, [
            'contain' => ['Countries'],
            'order' => ['id' => 'asc']
        ]);
        $user = $this->Authentication->getIdentity();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('cities'));
    }

    public function add()
    {
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Cities';
        $breadcrumControllers[1] = 'Cities';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Add City';
        $breadcrumControllers[2] = 'Cities';
        $breadcrumActions[2] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $city = $this->Cities->newEmptyEntity();
        if ($this->request->is('post')) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
        $countries = $this->Cities->Countries->find('list', ['order' => 'Countries.name asc']);
        $user = $this->Authentication->getIdentity();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('city', 'countries'));
    }

    public function edit($id = null)
    {
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Cities';
        $breadcrumControllers[1] = 'Cities';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Edit City';
        $breadcrumControllers[2] = 'Cities';
        $breadcrumActions[2] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $city = $this->Cities->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
        $countries = $this->Cities->Countries->find('list', ['order' => 'Countries.name asc'])->all();
        $user = $this->Authentication->getIdentity();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('city', 'countries'));
    }
}
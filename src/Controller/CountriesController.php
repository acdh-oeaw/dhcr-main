<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class CountriesController extends AppController
{
    public ?string $modelClass = 'DhcrCore.Countries';

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        // required for contributors menu
        $user = $this->Authentication->getIdentity();
        $this->set('user_role_id', $user->user_role_id);
        $this->viewBuilder()->setLayout('contributors');
    }

    public function index()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user->is_admin) {
            $this->Flash->error(__('Not authorized to countries index'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Countries';
        $breadcrumControllers[1] = 'Countries';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $countries = $this->paginate($this->Countries);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('countries'));
    }

    public function add()
    {
        $country = $this->Countries->newEmptyEntity();
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($country);
        if ($this->request->is('post')) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            if ($this->Countries->save($country)) {
                $this->Flash->success('The country has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The country could not be saved. Please, try again.');
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Countries';
        $breadcrumControllers[1] = 'Countries';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Add Country';
        $breadcrumControllers[2] = 'Countries';
        $breadcrumActions[2] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('country'));
    }

    public function edit($id = null)
    {
        $country = $this->Countries->get($id);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($country);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $country = $this->Countries->patchEntity($country, $this->request->getData());
            if ($this->Countries->save($country)) {
                $this->Flash->success('The country has been saved.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The country could not be saved. Please, try again.');
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('country'));
    }
}

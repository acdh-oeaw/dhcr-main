<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class LanguagesController extends AppController
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
        $breadcrumTitles[1] = 'Languages';
        $breadcrumControllers[1] = 'Languages';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $languages = $this->paginate($this->Languages);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('languages'));
    }

    public function add()
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Languages';
        $breadcrumControllers[1] = 'Languages';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Add Language';
        $breadcrumControllers[2] = 'Languages';
        $breadcrumActions[2] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $language = $this->Languages->newEmptyEntity();
        if ($this->request->is('post')) {
            $language = $this->Languages->patchEntity($language, $this->request->getData());
            if ($this->Languages->save($language)) {
                $this->Flash->success(__('The language has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The language could not be saved. Please, try again.'));
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('language'));
    }

    public function edit($id = null)
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Languages';
        $breadcrumControllers[1] = 'Languages';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Edit Language';
        $breadcrumControllers[2] = 'Languages';
        $breadcrumActions[2] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $language = $this->Languages->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $language = $this->Languages->patchEntity($language, $this->request->getData());
            if ($this->Languages->save($language)) {
                $this->Flash->success(__('The language has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The language could not be saved. Please, try again.'));
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('language'));
    }
}
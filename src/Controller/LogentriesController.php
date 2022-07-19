<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class LogentriesController extends AppController
{
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('contributors');
    }

    public function index()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user->is_admin) {
            $this->Flash->error(__('Not authorized to logentries index'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Log Entries';
        $breadcrumControllers[1] = 'Logentries';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->paginate = [
            'contain' => ['LogentryCodes', 'Users'],
            'order' => ['id' => 'asc']
        ];
        $logentries = $this->paginate($this->Logentries);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('logentries'));
    }

    public function view($id = null)
    {
        $logentry = $this->Logentries->get($id, ['contain' => ['LogentryCodes', 'Users']]);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($logentry);
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Log Entries';
        $breadcrumControllers[1] = 'Logentries';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Log Entry Details';
        $breadcrumControllers[2] = 'Logentries';
        $breadcrumActions[2] = 'view';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $logentriesMax = $this->Logentries->find('all', ['order' => 'id desc'])->first()->id;
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('logentry', 'logentriesMax'));
    }
}

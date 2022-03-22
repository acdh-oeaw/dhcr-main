<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class InviteTranslationsController extends AppController
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
        $breadcrumTitles[1] = 'Invite Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $inviteTranslations = $this->InviteTranslations->find('all', ['order' => 'sortOrder asc']);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslations'));
    }

    public function view($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $inviteTranslation = $this->InviteTranslations->get($id);
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Invite Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Invite Translation Details';
        $breadcrumControllers[2] = 'inviteTranslations';
        $breadcrumActions[2] = 'view';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslation'));
    }

    public function add()
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        $inviteTranslation = $this->InviteTranslations->newEmptyEntity();
        if ($this->request->is('post')) {
            $query = $this->InviteTranslations->find();
            $nextSortOrder = $query->select(['sortOrder' => $query->func()->max('sortorder')])->first()->sortOrder + 1;
            $inviteTranslation = $this->InviteTranslations->patchEntity($inviteTranslation, $this->request->getData());
            $inviteTranslation->sortOrder = $nextSortOrder;
            if( !strpos($inviteTranslation->messageBody, '-fullname-') ) {  // check for -fullname-
                $this->Flash->success(__('Error: -fullname- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if( !strpos($inviteTranslation->messageBody, '-passwordlink-') ) {  // check for -passwordlink-
                $this->Flash->success(__('Error: -passwordlink- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if ($this->InviteTranslations->save($inviteTranslation)) {
                $this->Flash->success(__('The invite translation has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invite translation could not be saved. Please, try again.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Invite Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Add Invite Translation';
        $breadcrumControllers[2] = 'inviteTranslations';
        $breadcrumActions[2] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslation'));
    }

    public function edit($id = null)
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        $inviteTranslation = $this->InviteTranslations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inviteTranslation = $this->InviteTranslations->patchEntity($inviteTranslation, $this->request->getData());
            if( !strpos($inviteTranslation->messageBody, '-fullname-') ) {  // check for required text in message body
                $this->Flash->success(__('Error: -fullname- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if( !strpos($inviteTranslation->messageBody, '-passwordlink-') ) {  // check for -passwordlink-
                $this->Flash->success(__('Error: -passwordlink- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if ($this->InviteTranslations->save($inviteTranslation)) {
                $this->Flash->success(__('The invite translation has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invite translation could not be saved. Please, try again.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Invite Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Edit Invite Translation';
        $breadcrumControllers[2] = 'inviteTranslations';
        $breadcrumActions[2] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslation'));
    }
}
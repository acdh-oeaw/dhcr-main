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
        if (!$user->is_admin) {
            $this->Flash->error(__('Not authorized to invitetranslations index'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $inviteTranslations = $this->InviteTranslations->find('all', ['order' => 'sortOrder asc', 'contain' => 'Languages']);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslations'));
    }

    public function view($id = null)
    {
        $inviteTranslation = $this->InviteTranslations->get($id, ['contain' => 'Languages']);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($inviteTranslation);
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Translation Details';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'view';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslation'));
    }

    public function add()
    {
        $inviteTranslation = $this->InviteTranslations->newEmptyEntity();
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($inviteTranslation);
        if ($this->request->is('post')) {
            $query = $this->InviteTranslations->find();
            $nextSortOrder = $query->select(['sortOrder' => $query->func()->max('sortorder')])->first()->sortOrder + 1;
            $inviteTranslation = $this->InviteTranslations->patchEntity($inviteTranslation, $this->request->getData());
            $inviteTranslation->sortOrder = $nextSortOrder;
            if (!strpos($inviteTranslation->messageBody, '-fullname-')) {  // check for -fullname-
                $this->Flash->success(__('Error: -fullname- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if (!strpos($inviteTranslation->messageBody, '-passwordlink-')) {  // check for -passwordlink-
                $this->Flash->success(__('Error: -passwordlink- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if ($this->InviteTranslations->save($inviteTranslation)) {
                $this->Flash->success(__('The invite translation has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be added. Please, try again.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Add Translation';
        $breadcrumControllers[2] = 'inviteTranslations';
        $breadcrumActions[2] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $languages = $this->InviteTranslations->Languages->find('list', ['order' => 'Languages.name asc']);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslation', 'languages'));
    }

    public function edit($id = null)
    {
        $inviteTranslation = $this->InviteTranslations->get($id);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($inviteTranslation);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inviteTranslation = $this->InviteTranslations->patchEntity($inviteTranslation, $this->request->getData());
            if (!strpos($inviteTranslation->messageBody, '-fullname-')) {  // check for required text in message body
                $this->Flash->success(__('Error: -fullname- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if (!strpos($inviteTranslation->messageBody, '-passwordlink-')) {  // check for -passwordlink-
                $this->Flash->success(__('Error: -passwordlink- missing in message.'));
                return $this->redirect(['action' => 'index']);
            }
            if ($this->InviteTranslations->save($inviteTranslation)) {
                $this->Flash->success(__('The invite translation has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be updated. Please, try again.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Edit Translation';
        $breadcrumControllers[2] = 'inviteTranslations';
        $breadcrumActions[2] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $languages = $this->InviteTranslations->Languages->find('list', ['order' => 'Languages.name asc']);
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('inviteTranslation', 'languages'));
    }
}

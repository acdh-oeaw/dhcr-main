<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * InviteTranslations Controller
 *
 * @property \App\Model\Table\InviteTranslationsTable $InviteTranslations
 * @method \App\Model\Entity\InviteTranslation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InviteTranslationsController extends AppController
{
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        // required for contributors menu
        $user = $this->Authentication->getIdentity();
        $this->set('user_role_id', $user->user_role_id);
        $this->viewBuilder()->setLayout('contributors');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Invite Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $inviteTranslations = $this->InviteTranslations->find('all', ['order' => 'sortOrder asc']);
        $this->set(compact('inviteTranslations'));
    }

    /**
     * View method
     *
     * @param string|null $id Invite Translation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inviteTranslation = $this->InviteTranslations->get($id, [
            'contain' => [],
        ]);

        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'Invite Translations';
        $breadcrumControllers[1] = 'inviteTranslations';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = $inviteTranslation->name;
        $breadcrumControllers[2] = 'inviteTranslations';
        $breadcrumActions[2] = 'view';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        
        $user = $this->Authentication->getIdentity();
        $this->set(compact('inviteTranslation', 'user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inviteTranslation = $this->InviteTranslations->newEmptyEntity();
        if ($this->request->is('post')) {
            $query = $this->InviteTranslations->find();
            $nextSortOrder = $query->select(['sortOrder' => $query->func()->max('sortorder')])->first()->sortOrder + 1;
            $inviteTranslation = $this->InviteTranslations->patchEntity($inviteTranslation, $this->request->getData());
            $inviteTranslation->sortOrder = $nextSortOrder;
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
        
        $this->set(compact('inviteTranslation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invite Translation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inviteTranslation = $this->InviteTranslations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inviteTranslation = $this->InviteTranslations->patchEntity($inviteTranslation, $this->request->getData());
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

        $this->set(compact('inviteTranslation'));
    }
}
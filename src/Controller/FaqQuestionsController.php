<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class FaqQuestionsController extends AppController
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
            $this->Flash->error(__('Not authorized to FAQ Questions index'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'FAQ Questions';
        $breadcrumControllers[1] = 'FaqQuestions';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $this->set(compact('user')); // required for contributors menu


        $this->paginate = [
            'contain' => ['FaqCategories'],
        ];  // order by sortOrder ASC
        $faqQuestions = $this->paginate($this->FaqQuestions);
        $this->set(compact('faqQuestions'));
    }

    public function view($id = null)
    {
        $faqQuestion = $this->FaqQuestions->get($id, [
            'contain' => ['FaqCategories'],
        ]);
        $user = $this->Authentication->getIdentity();
        // $this->Authorization->authorize($faqQuestion);
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'FAQ Questions';
        $breadcrumControllers[1] = 'FaqQuestions';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'View FAQ Question';
        $breadcrumControllers[2] = 'FaqQuestions';
        $breadcrumActions[2] = 'view';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('faqQuestion'));
    }

    public function add()
    {
        $faqQuestion = $this->FaqQuestions->newEmptyEntity();
        $user = $this->Authentication->getIdentity();
        // $this->Authorization->authorize($faqQuestion);
        if ($this->request->is('post')) {
            $faqQuestion = $this->FaqQuestions->patchEntity($faqQuestion, $this->request->getData());
            if ($this->FaqQuestions->save($faqQuestion)) {
                $this->Flash->success(__('The faq question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq question could not be saved. Please, try again.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'FAQ Questions';
        $breadcrumControllers[1] = 'FaqQuestions';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Add FAQ Question';
        $breadcrumControllers[2] = 'FaqQuestions';
        $breadcrumActions[2] = 'add';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $faqCategories = $this->FaqQuestions->FaqCategories->find('list', ['limit' => 200]);
        $this->set(compact('faqQuestion', 'faqCategories'));
    }

    public function edit($id = null)
    {
        $faqQuestion = $this->FaqQuestions->get($id, [
            'contain' => [],
        ]);
        $user = $this->Authentication->getIdentity();
        // $this->Authorization->authorize($faqQuestion);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faqQuestion = $this->FaqQuestions->patchEntity($faqQuestion, $this->request->getData());
            if ($this->FaqQuestions->save($faqQuestion)) {
                $this->Flash->success(__('The faq question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq question could not be saved. Please, try again.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $breadcrumTitles[1] = 'FAQ Questions';
        $breadcrumControllers[1] = 'FaqQuestions';
        $breadcrumActions[1] = 'index';
        $breadcrumTitles[2] = 'Edit FAQ Question';
        $breadcrumControllers[2] = 'FaqQuestions';
        $breadcrumActions[2] = 'edit';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $faqCategories = $this->FaqQuestions->FaqCategories->find('list', ['limit' => 200]);
        $this->set(compact('faqQuestion', 'faqCategories'));
    }
}

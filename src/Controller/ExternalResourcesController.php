<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ExternalResourcesController extends AppController
{
    public $modelClass = null;
    public $Courses = null;

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('contributors');
    }

    public function index()
    {
        $modelClass = 'DhcrCore.ExternalResources';
        $user = $this->Authentication->getIdentity();
        if (!$user->is_admin) {
            $this->Flash->error(__('Not authorized to externalResources index'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'External Resources Index';
        $breadcrumControllers[1] = 'ExternalResources';
        $breadcrumActions[1] = 'index';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $query = $this->ExternalResources->find('all')->contain('Courses');
        $this->set('externalResources', $this->paginate($query, ['order' => ['ExternalResources.id' => 'ASC']]));
        $this->set(compact('user')); // required for contributors menu
    }

    public function showExtResources($courseId)
    {
        $modelClass = 'DhcrCore.Courses';
        $this->loadModel('DhcrCore.Courses');
        $course = $this->Courses->get($courseId, ['contain' => ['ExternalResources']]);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($course);
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Show External Resources';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'showExtResources';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('course'));
    }

    public function addExtResource($courseId)
    {
        $modelClass = 'DhcrCore.Courses';
        $this->loadModel('DhcrCore.Courses');
        $course = $this->Courses->get($courseId);
        $externalResource = $this->Courses->ExternalResources->newEmptyEntity();
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($course);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $externalResource = $this->Courses->ExternalResources->patchEntity($externalResource, $this->request->getData());
            if ($this->Courses->ExternalResources->save($externalResource)) {
                $this->Flash->success(__('The external resource has been added.'));
                return $this->redirect(['action' => 'showExtResources', $courseId]);
            }
            $this->Flash->error(__('The external resource could not be added. Please check the error message.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Add External Resource';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'addExtResource';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('course', 'externalResource'));
        // "customize" view
        $this->set('icon', 'plus');
        $this->set('action', 'Add');
        $this->set('submit_label', 'Add');
        $this->render('add_edit_ext_resource');
    }

    public function editExtResource($externalResourceId)
    {
        $modelClass = 'DhcrCore.Courses';
        $this->loadModel('DhcrCore.Courses');
        $externalResource = $this->Courses->ExternalResources->get($externalResourceId);
        $courseId = $externalResource->course_id;
        $course = $this->Courses->get($courseId);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($course);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $externalResource = $this->Courses->ExternalResources->patchEntity($externalResource, $this->request->getData());
            if ($this->Courses->ExternalResources->save($externalResource)) {
                $this->Flash->success(__('The external resource has been updated.'));
                return $this->redirect(['action' => 'showExtResources', $courseId]);
            }
            $this->Flash->error(__('The external resource could not be updated. Please check the error message.'));
        }
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'adminCourses';
        $breadcrumTitles[1] = 'Edit External Resource';
        $breadcrumControllers[1] = 'Courses';
        $breadcrumActions[1] = 'editExtResource';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('course', 'externalResource'));
        // "customize" view
        $this->set('icon', 'pencil');
        $this->set('action', 'Edit');
        $this->set('submit_label', 'Update');
        $this->render('add_edit_ext_resource');
    }
}

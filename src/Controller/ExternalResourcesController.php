<?php

declare(strict_types=1);

namespace App\Controller;

class ExternalResourcesController extends AppController
{
    public $modelClass = 'DhcrCore.Courses';
    public $Courses = null;

    public function showExtResources($courseId)
    {
        $this->loadModel('DhcrCore.Courses');
        $course = $this->Courses->get($courseId, ['contain' => ['ExternalResources']]);
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($course);
        $this->viewBuilder()->setLayout('contributors');
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
        $this->viewBuilder()->setLayout('contributors');
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
        $this->viewBuilder()->setLayout('contributors');
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

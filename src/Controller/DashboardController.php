<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

class DashboardController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('contributors');
    }

    public function index()
    {
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user, 'accessDashboard');

        // $identity = $this->_checkExternalIdentity();

        $this->set('title_for_layout', 'DHCR Dashboard');
        $this->set(compact('user'));
    }


    public function needsAttention()
    {
        $this->loadModel('Users');
        $this->loadModel('Courses');

        // Set breadcrums
        $breadcrumTitles[0] = 'Needs Attention';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'needsAttention';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $pendingAccountRequests = $this->Users->find()->where(['approved' => 0])->count();
        $pendingCourseRequests = $this->Courses->find()->where(['approved' => 0])->count();

        $expiryDate = new FrozenDate('-10 months'); // in new implementation the expiry mails will be sent after 10 months
        $expiredCourses = $this->Courses->find()
            ->where([
                'updated <=' => $expiryDate,
                'active' => 1,
                'deleted' => 0
            ])
            ->count();
        // todo: show all for admin and show only country specific for moderator, only user specific for contributor

        $this->set('title', 'Needs Attention');
        $user = $this->Authentication->getIdentity();
        $this->set(compact('user', 'pendingAccountRequests', 'pendingCourseRequests', 'expiredCourses'));
    }

    public function adminCourses()
    {
        $this->loadModel('Courses');

        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'courses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $user = $this->Authentication->getIdentity();
        $myCoursesNr = $this->Courses->find()->where(['user_id' => $user->id])->count();
        if($user->user_role_id < 3) {
            // Moderator oder Administrator
            // todo: implement after finishing moderated courses
            $moderatedCoursesNr = 1;
        } else {
            $moderatedCoursesNr = 0;
        }
        $this->set(compact('user', 'myCoursesNr', 'moderatedCoursesNr'));
    }

    public function contributorNetwork()
    {
        $this->loadModel('Users');

        // Set breadcrums
        $breadcrumTitles[0] = 'Contributor Network';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'contributorNetwork';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $user = $this->Authentication->getIdentity();

        if($user->user_role_id > 0) {
            // Administrator
            $totalUsers = $this->Users->find()->count();
        } else {
            $totalUsers = 0;
        }
        $this->set(compact('totalUsers'));
    }

    public function categoryLists()
    {
        $this->loadModel('Cities');
        $this->loadModel('Institutions');
        $this->loadModel('Languages');
        
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $user = $this->Authentication->getIdentity();

        $totalCities = $this->Cities->find()->count();
        $totalInstitutions = $this->Institutions->find()->count();
        $totalLanguages = $this->Languages->find()->count();

        $this->set(compact('totalCities', 'totalInstitutions', 'totalLanguages'));
    }
}

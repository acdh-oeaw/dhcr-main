<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;
use Cake\Event\EventInterface;

class DashboardController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

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

        $user = $this->Authentication->getIdentity();
        $pendingAccountRequests = $this->Users->find()->where(['approved' => 0])->count();
        $pendingCourseRequests = $this->Courses->find()->where(['approved' => 0])->count();
        
        $expiryDate = new FrozenDate('-10 months'); // in new implementation the expiry mails will be sent after 10 months
        if( $user->user_role_id == 2 || $user->is_admin ) {
            $expiredCourses = $this->Courses->find()
                                            ->where([
                                                'updated <=' => $expiryDate,
                                                'active' => 1,
                                                'deleted' => 0
                                            ])
                                            ->count();
        } else {
            $expiredCourses = $this->Courses->find()
                                            ->where([
                                                'updated <=' => $expiryDate,
                                                'active' => 1,
                                                'deleted' => 0,
                                                'user_id' => $user->id
                                            ])
                                            ->count();
        }
        
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
        
        $myCoursesCount = $this->Courses->find()->where(['user_id' => $user->id])->count();
        // $moderatedCoursesCount = return $this->Courses->find()->where(['user_id' => $user_id])->count();
        $moderatedCoursesCount = 1;
        // $allCoursesCount = return $this->Courses->find()->where(['user_id' => $user_id])->count();
        $allCoursesCount = 2;
        $this->set(compact('user', 'myCoursesCount', 'moderatedCoursesCount', 'allCoursesCount'));
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

        if( $user->is_admin ) {
            $totalUsers = $this->Users->find()->count();
        } else {
            $totalUsers = 0;
        }
        $this->set(compact('user', 'totalUsers'));
    }

    public function categoryLists()
    {
        $this->loadModel('Cities');
        $this->loadModel('Institutions');
        $this->loadModel('Languages');
        $this->loadModel('InviteTranslations');
        
        // Set breadcrums
        $breadcrumTitles[0] = 'Category Lists';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'categoryLists';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $user = $this->Authentication->getIdentity();

        $totalCities = $this->Cities->find()->count();
        $totalInstitutions = $this->Institutions->find()->count();
        $totalLanguages = $this->Languages->find()->count();
        if ($user->is_admin) {
            $totalInviteTranslations = $this->InviteTranslations->find()->count();
        } else {
            $totalInviteTranslations = 0;
        }

        $this->set(compact('user', 'totalCities', 'totalInstitutions', 'totalLanguages', 'totalInviteTranslations'));
    }

    public function profileSettings()
    {
        // Set breadcrums
        $breadcrumTitles[0] = 'Profile Settings';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'profileSettings';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
    }
}

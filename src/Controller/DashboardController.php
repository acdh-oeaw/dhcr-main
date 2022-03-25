<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
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
        $this->viewBuilder()->setLayout('contributors');
    }

    public function index()
    {
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user, 'accessDashboard');
        // $identity = $this->_checkExternalIdentity();
        $this->set(compact('user')); // required for contributors menu
    }

    public function needsAttention()
    {
        $this->loadModel('Users');
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Needs Attention';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'needsAttention';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $user = $this->Authentication->getIdentity();
        $reminderDate = new FrozenTime('-10 months');
        $hideDate =     new FrozenTime('-18 months');
        if($user->is_admin) {
            $pendingAccountRequests = $this->Users->find()->where([
                                                                    'approved' => 0,
                                                                    'active' => 1
                                                                    ])
                                                                    ->count();
            $pendingCourseRequests = $this->Courses->find()->where([
                                                                    'approved' => 0,
                                                                    'deleted' => 0
                                                                    ])
                                                                    ->count();
            $expiredCourses = $this->Courses->find()->where([
                                                                    'active' => 1,
                                                                    'deleted' => 0,
                                                                    'updated <=' => $reminderDate,
                                                                    'updated >=' => $hideDate
                                                                    ])
                                                                    ->count();
        } elseif($user->user_role_id == 2) {
            $pendingAccountRequests = $this->Users->find()->where([
                                                                    'approved' => 0,
                                                                    'active' => 1,
                                                                    'country_id' => $user->country_id
                                                                    ])
                                                                    ->count();
            $pendingCourseRequests = $this->Courses->find()->where([
                                                                    'approved' => 0,
                                                                    'deleted' => 0,
                                                                    'country_id' => $user->country_id
                                                                    ])->count();
            $expiredCourses = $this->Courses->find()->where([
                                                                    'active' => 1,
                                                                    'deleted' => 0,
                                                                    'updated <=' => $reminderDate,
                                                                    'updated >=' => $hideDate,
                                                                    'country_id' => $user->country_id
                                                                    ])
                                                                    ->count();
        } else {
            $pendingAccountRequests = 0;
            $pendingCourseRequests = 0;
            $expiredCourses = $this->Courses->find()->where([
                                                            'active' => 1,
                                                            'deleted' => 0,
                                                            'updated <=' => $reminderDate,
                                                            'updated >=' => $hideDate,
                                                            'user_id' => $user->id
                                                            ])
                                                            ->count();
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('pendingAccountRequests', 'pendingCourseRequests', 'expiredCourses'));
    }

    public function adminCourses()
    {
        $this->loadModel('DhcrCore.Courses');
        // Set breadcrums
        $breadcrumTitles[0] = 'Administrate Courses';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'courses';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));

        $user = $this->Authentication->getIdentity();
        $hideDate =     new FrozenTime('-18 months');
        $myCoursesCount = $this->Courses->find()->where([
                                                        'deleted' => 0,
                                                        'updated >=' => $hideDate,
                                                        'user_id' => $user->id
                                                        ])
                                                        ->count();
        if($user->user_role_id == 2) {
            $moderatedCoursesCount = $this->Courses->find()->where([
                                                                    'deleted' => 0,
                                                                    'updated >=' => $hideDate,
                                                                    'country_id' => $user->country_id,
                                                                    'approved' => 1
                                                                    ])
                                                                    ->count();
        } else {
            $moderatedCoursesCount = 0;
        }
        if($user->is_admin) {
            $allCoursesCount = $this->Courses->find()->where([
                                                            'deleted' => 0,
                                                            'updated >=' => $hideDate
                                                            ])
                                                            ->count();
        } else {
            $allCoursesCount = 0;
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('myCoursesCount', 'moderatedCoursesCount', 'allCoursesCount'));
    }

    public function contributorNetwork()
    {
        $user = $this->Authentication->getIdentity();
        // todo add auth
        $this->loadModel('Users');
        // Set breadcrums
        $breadcrumTitles[0] = 'Contributor Network';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'contributorNetwork';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        if( $user->user_role_id == 2 ) {
            $moderatedUsersCount = $this->Users->find()->where([
                                                                'active' => 1,
                                                                'country_id' => $user->country_id
                                                                ])
                                                                ->count();
        } else {
            $moderatedUsersCount = 0;
        }
        if( $user->is_admin ) {
            $allUsersCount = $this->Users->find()->where(['active' => 1])->count();
        } else {
            $allUsersCount = 0;
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('moderatedUsersCount', 'allUsersCount'));
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
        if($user->is_admin) {
            $totalLanguages = $this->Languages->find()->count();
            $totalInviteTranslations = $this->InviteTranslations->find()->count();
        } else {
            $totalLanguages = 0;
            $totalInviteTranslations = 0;
        }
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('totalCities', 'totalInstitutions', 'totalLanguages', 'totalInviteTranslations'));
    }

    public function profileSettings()
    {
        // Set breadcrums
        $breadcrumTitles[0] = 'Profile Settings';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'profileSettings';
        $user = $this->Authentication->getIdentity();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions'));
    }
}
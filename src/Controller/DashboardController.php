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
        $breadcrumTitles[0] = 'Needs attention';
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
}

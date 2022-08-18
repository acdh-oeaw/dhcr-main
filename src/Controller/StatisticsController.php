<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;

class StatisticsController extends AppController
{
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('contributors');
    }

    public function summaryStatistics()
    {
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user);
        // set breadcrums
        $breadcrumTitles[0] = 'Statistics';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'Statistics';
        $breadcrumTitles[1] = 'Summary Statistics';
        $breadcrumControllers[1] = 'Statistics';
        $breadcrumActions[1] = 'summaryStatistics';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        // load models
        $this->loadModel('DhcrCore.Courses');
        $this->loadModel('Users');
        $this->loadModel('Institutions');
        $this->loadModel('InviteTranslations');
        // get statistic data
        //  courses
        $coursesTotal = $this->Courses->find()->count();
        $coursesAvailable = $this->Courses->find()->where([
            'active' => 1,
            'deleted' => 0,
        ])
            ->count();
        $coursesShortArchived = $this->Courses->find()->where([
            'active' => 1,
            'deleted' => 0,
            'updated >' => new FrozenTime('-30 Months'),
        ])
            ->count();
        $coursesInBackend = $this->Courses->find()->where([
            'active' => 1,
            'deleted' => 0,
            'updated >' => Configure::read('courseArchiveDate'),
        ])
            ->count();
        $coursesPublic = $this->Courses->find()->where([
            'active' => 1,
            'deleted' => 0,
            'updated >' => new FrozenTime('-489 Days'),
        ])
            ->count();  // ca. 16 Months
        //  users
        $usersTotal = $this->Users->find()->count();
        $usersAvailable = $this->Users->find()->where([
            'email_verified' => 1,
            'password IS NOT NULL',
            'approved' => 1,
            'active' => 1,
        ])->count();
        $users2Years = $this->Users->find()->where([
            'email_verified' => 1,
            'password IS NOT NULL',
            'approved' => 1,
            'active' => 1,
            'last_login >' => new FrozenTime('-2 Years')
        ])->count();
        $users1Year = $this->Users->find()->where([
            'email_verified' => 1,
            'password IS NOT NULL',
            'approved' => 1,
            'active' => 1,
            'last_login >' => new FrozenTime('-1 Year')
        ])->count();
        $users6Months = $this->Users->find()->where([
            'email_verified' => 1,
            'password IS NOT NULL',
            'approved' => 1,
            'active' => 1,
            'last_login >' => new FrozenTime('-6 Months')
        ])->count();
        $users2Months = $this->Users->find()->where([
            'email_verified' => 1,
            'password IS NOT NULL',
            'approved' => 1,
            'active' => 1,
            'last_login >' => new FrozenTime('-2 Months')
        ])->count();
        $users1Month = $this->Users->find()->where([
            'email_verified' => 1,
            'password IS NOT NULL',
            'approved' => 1,
            'active' => 1,
            'last_login >' => new FrozenTime('-1 Months')
        ])->count();
        //  institutions
        $institutionsTotal = $this->Institutions->find('all')->count();
        // translations
        $inviteTranslationsTotal = $this->InviteTranslations->find('all')->count();
        $inviteTranslationsActive = $this->InviteTranslations->find('all')->where(['active ' => true])->count();
        $this->set(compact('user')); // required for contributors menu
        $this->set(compact('coursesTotal', 'coursesAvailable', 'coursesShortArchived', 'coursesInBackend', 'coursesPublic'));
        $this->set(compact('usersTotal', 'usersAvailable', 'users2Years', 'users1Year', 'users6Months', 'users2Months', 'users1Month'));
        $this->set(compact('institutionsTotal'));
        $this->set(compact('inviteTranslationsTotal', 'inviteTranslationsActive'));
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class HelpController extends AppController
{
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('contributors');
    }

    public function contributorFaq()
    {
        $user = $this->Authentication->getIdentity();
        // Set breadcrums
        $breadcrumTitles[0] = 'Help';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'help';
        $breadcrumTitles[1] = 'Contributor FAQ';
        $breadcrumControllers[1] = 'Help';
        $breadcrumActions[1] = 'contributorFaq';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
    }

    public function moderatorFaq()
    {
        $user = $this->Authentication->getIdentity();
        $this->Authorization->authorize($user);
        // Set breadcrums
        $breadcrumTitles[0] = 'Help';
        $breadcrumControllers[0] = 'Dashboard';
        $breadcrumActions[0] = 'help';
        $breadcrumTitles[1] = 'Moderator FAQ';
        $breadcrumControllers[1] = 'Help';
        $breadcrumActions[1] = 'moderatorFaq';
        $this->set((compact('breadcrumTitles', 'breadcrumControllers', 'breadcrumActions')));
        $this->set(compact('user')); // required for contributors menu
    }
}

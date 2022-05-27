<?php

namespace App\Mailer;

use App\Model\Entity\Subscription;
use Cake\Core\Configure;
use Cake\Mailer\Transport\DebugTransport;

class SubscriptionMailer extends AppMailer
{

    public function access(Subscription $subscription)
    {
        $this
            ->setTo($subscription['email'])
            ->setSubject('Your Subscription')
            ->setViewVars(['subscription' => $subscription, 'isNew' => false])
            ->viewBuilder()->setTemplate('subscription/access');
    }

    public function confirm(Subscription $subscription)
    {
        $this
            ->setTo($subscription['email'])
            ->setSubject('Subscription Confirmation')
            ->setEmailFormat('text')
            ->setViewVars(['subscription' => $subscription])
            ->viewBuilder()->setTemplate('subscription/confirmation');
    }

    public function notification(Subscription $subscription, $courses = [])
    {
        $this
            ->setTo($this->preventMailbombing($subscription->email))
            ->setSubject('New Course Notification')
            ->setViewVars([
                'subscription' => $subscription,
                'courses' => $courses
            ])
            ->viewBuilder()->setTemplate('subscription/notification');
    }
}

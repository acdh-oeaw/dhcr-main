<?php

namespace App\Mailer;

use App\Model\Entity\Subscription;

class SubscriptionMailer extends AppMailer
{

    public function confirm(Subscription $subscription)
    {
        $this
            ->setTo($subscription['email'])
            ->setSubject('Confirm your Course Alert')
            ->setEmailFormat('text')
            ->setViewVars(['subscription' => $subscription])
            ->viewBuilder()->setTemplate('subscription/confirmation');
    }

    public function access(Subscription $subscription)
    {
        $this
            ->setTo($subscription['email'])
            ->setSubject('Your Course Alert')
            ->setViewVars(['subscription' => $subscription])
            ->viewBuilder()->setTemplate('subscription/access');
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

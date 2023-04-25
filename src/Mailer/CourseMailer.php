<?php

namespace App\Mailer;

use DhcrCore\Model\Entity\Course;

class CourseMailer extends AppMailer
{

    public function notifyAdmin(Course $course, $adminAddress)
    {
        $this
            ->setTo($this->preventMailbombing($adminAddress))
            ->setCc($this->preventMailbombing(env('APP_MAIL_DEFAULT_CC')))
            ->setSubject('New Course waiting for approval')
            ->setViewVars(['course' => $course])
            ->viewBuilder()->setTemplate('courses/notify_admin');
    }
}

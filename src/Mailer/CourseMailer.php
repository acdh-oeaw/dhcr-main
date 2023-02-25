<?php

namespace App\Mailer;

use DhcrCore\Model\Entity\Course;

class CourseMailer extends AppMailer
{

    public function notifyAdmin(Course $course, $adminAddress)
    {
        $this
            ->setTo($this->preventMailbombing($adminAddress))
            ->setSubject('New Course waiting for approval')
            ->setViewVars(['course' => $course])
            ->viewBuilder()->setTemplate('courses/notify_admin');
    }
}

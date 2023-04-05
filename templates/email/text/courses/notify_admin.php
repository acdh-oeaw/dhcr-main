<?php

use Cake\Core\Configure;
?>
Hello Admin,

A new course has been entered in the DHCR and is waiting for approval!

Course Overview
• Course Name: <?= $course->name ?>

• Education Type: <?= $course->course_type->name ?>

• Institution: <?= $course->institution->name ?>


Click here to go to "Course Approval", check the details and approve the course:
<?= Configure::read('dhcr.baseUrl') . 'courses/approve/' ?>
<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class CourseType extends Entity
{
    protected $_accessible = [
        'course_parent_type_id' => true,
        'name' => true,
        'course_parent_type' => true,
        'courses' => true,
        'subscriptions' => true,
    ];
}

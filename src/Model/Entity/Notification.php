<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Notification extends Entity
{
    protected $_accessible = [
        'course_id' => true,
        'subscription_id' => true,
        'course' => true,
        'subscription' => true,
    ];
}

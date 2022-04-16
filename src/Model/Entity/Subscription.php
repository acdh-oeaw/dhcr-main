<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Subscription extends Entity
{
    protected $_accessible = [
        'email' => true,
        'country_id' => true,
        'online_course' => true,
        'confirmed' => true,
        'confirmation_key' => true,
        'deletion_key' => true,
        'created' => true,
        'updated' => true,
        'notifications' => true,
        'languages' => true,
        'course_types' => true,
        'disciplines' => true,
        'countries' => true,
        'tadirah_techniques' => true,
        'tadirah_objects' => true
    ];
}

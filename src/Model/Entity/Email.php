<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Email extends Entity
{
    protected $_accessible = [
        'country_id' => true,
        'email' => true,
        'first_name' => true,
        'last_name' => true,
        'telephone' => true,
        'message' => true,
        'country' => true
    ];
}

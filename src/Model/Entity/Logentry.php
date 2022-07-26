<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Logentry extends Entity
{
    protected $_accessible = [
        'logentry_code_id' => true,
        'user_id' => true,
        'source_name' => true,
        'subject' => true,
        'description' => true,
        'cleared' => true,
        'created' => true,
        'logentry_code' => true,
        'user' => true,
    ];
}

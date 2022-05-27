<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Language extends Entity
{
    protected $_accessible = [
        'name' => true,
        'courses' => true,
        'subscriptions' => true,
    ];
}

<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class City extends Entity
{
    protected $_accessible = [
        'country_id' => true,
        'name' => true,
        'country' => true,
        'courses' => true,
        'institutions' => true,
    ];
}

<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Institution extends Entity
{
    protected $_accessible = [
        'city_id' => true,
        'country_id' => true,
        'name' => true,
        'description' => true,
        'url' => true,
        'lon' => true,
        'lat' => true,
        'created' => true,
        'updated' => true,
        'city' => true,
        'country' => true,
        'courses' => true,
        'users' => true,
    ];
}

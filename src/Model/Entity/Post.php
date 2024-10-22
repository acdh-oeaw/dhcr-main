<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Post extends Entity
{
    protected $_accessible = [
        'title' => true,
        'external_link' => true,
        'body' => true,
        'publication_date' => true,
        'expiry_date' => true,
        'publish' => true,
        'created' => true,
        'updated' => true,
    ];
}

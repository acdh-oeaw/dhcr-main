<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class InviteTranslation extends Entity
{
    protected $_accessible = [
        'language_id' => true,
        'sortOrder' => true,
        'subject' => true,
        'messageBody' => true,
        'created' => true,
        'updated' => true,
        'active' => true,
    ];
}

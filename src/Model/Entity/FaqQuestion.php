<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class FaqQuestion extends Entity
{
    protected $_accessible = [
        'faq_category_id' => true,
        'sort_order' => true,
        'question' => true,
        'answer' => true,
        'link_title' => true,
        'link_url' => true,
        'published' => true,
        'faq_category' => true,
    ];
}

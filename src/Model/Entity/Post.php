<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $external_link
 * @property string|null $body
 * @property \Cake\I18n\FrozenTime|null $publication_date
 * @property \Cake\I18n\FrozenTime|null $expiry_date
 * @property bool $publish
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $updated
 */
class Post extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
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

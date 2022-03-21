<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InviteTranslation Entity
 *
 * @property int $id
 * @property int $sortOrder
 * @property string $name
 * @property string $subject
 * @property string $messageBody
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $updated
 * @property bool $active
 */
class InviteTranslation extends Entity
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
        'sortOrder' => true,
        'name' => true,
        'subject' => true,
        'messageBody' => true,
        'created' => true,
        'updated' => true,
        'active' => true,
    ];
}

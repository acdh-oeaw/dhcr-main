<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subscription Entity
 *
 * @property int $id
 * @property string $email
 * @property bool|null $online_course
 * @property bool $confirmed
 * @property string $confirmation_key
 * @property string|null $deletion_key
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $updated
 *
 * @property \App\Model\Entity\Notification[] $notifications
 */
class Subscription extends Entity
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
        'email' => true,
        'country_id' => true,
        'online_course' => true,
        'confirmed' => true,
        'confirmation_key' => true,
        'deletion_key' => true,
        'created' => true,
        'updated' => true,
        'notifications' => true,
        'languages' => true,
        'course_types' => true,
        'disciplines' => true,
        'countries' => true,
        'tadirah_techniques' => true,
        'tadirah_objects' => true
    ];
}

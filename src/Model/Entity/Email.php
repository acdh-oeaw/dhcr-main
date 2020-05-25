<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Email Entity
 *
 * @property int $id
 * @property int|null $country_id
 * @property string $email
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $telephone
 * @property string|null $message
 *
 * @property \App\Model\Entity\Country $country
 */
class Email extends Entity
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
        'country_id' => true,
        'email' => true,
        'first_name' => true,
        'last_name' => true,
        'telephone' => true,
        'message' => true,
        'country' => true
    ];
}

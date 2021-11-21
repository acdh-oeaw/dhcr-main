<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * City Entity
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Institution[] $institutions
 */
class City extends Entity
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
        'name' => true,
        'country' => true,
        'courses' => true,
        'institutions' => true,
    ];
}

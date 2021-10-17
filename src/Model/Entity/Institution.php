<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Institution Entity
 *
 * @property int $id
 * @property int|null $city_id
 * @property int|null $country_id
 * @property string $name
 * @property string|null $description
 * @property string|null $url
 * @property string|null $lon
 * @property string|null $lat
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $updated
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\User[] $users
 */
class Institution extends Entity
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

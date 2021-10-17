<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Country Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $domain_name
 * @property string|null $alpha_3
 * @property string|null $stop_words
 *
 * @property \App\Model\Entity\City[] $cities
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Email[] $emails
 * @property \App\Model\Entity\Institution[] $institutions
 * @property \App\Model\Entity\Subscription[] $subscriptions
 * @property \App\Model\Entity\User[] $users
 */
class Country extends Entity
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
        'name' => true,
        'domain_name' => true,
        'alpha_3' => true,
        'stop_words' => true,
        'cities' => true,
        'courses' => true,
        'emails' => true,
        'institutions' => true,
        'subscriptions' => true,
        'users' => true,
    ];
}

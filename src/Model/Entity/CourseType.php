<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseType Entity
 *
 * @property int $id
 * @property int $course_parent_type_id
 * @property string $name
 *
 * @property \App\Model\Entity\CourseParentType $course_parent_type
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Subscription[] $subscriptions
 */
class CourseType extends Entity
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
        'course_parent_type_id' => true,
        'name' => true,
        'course_parent_type' => true,
        'courses' => true,
        'subscriptions' => true,
    ];
}

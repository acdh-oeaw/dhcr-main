<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * CourseParentType Entity
 *
 * @property int $id
 * @property string $name
 *
 * @property \App\Model\Entity\CourseType[] $course_types
 * @property \App\Model\Entity\Course[] $courses
 */
class CourseParentType extends Entity
{
    
    use LazyLoadEntityTrait;
    
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
        'course_types' => true,
        'courses' => true
    ];
    
    protected $_hidden = [
        'courses'
    ];
    
    
    protected function _getCourseCount() {
        return count($this->courses);
    }
}

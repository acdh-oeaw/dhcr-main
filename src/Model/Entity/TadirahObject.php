<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * TadirahObject Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property \App\Model\Entity\Course[] $courses
 */
class TadirahObject extends Entity
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
        'description' => true,
        'courses' => true
    ];
	
	protected $_hidden = [
		'_joinData',
        'courses'
	];
    
    protected function _getCourseCount() {
        return count($this->courses);
    }
}

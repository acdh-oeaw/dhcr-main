<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * Country Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $domain_name
 * @property string|null $stop_words
 *
 * @property \App\Model\Entity\City[] $cities
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Institution[] $institutions
 * @property \App\Model\Entity\User[] $users
 */
class Country extends Entity
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
        'domain_name' => true,
        'stop_words' => true,
        'cities' => true,
        'courses' => true,
        'institutions' => true,
        'users' => false
    ];
    
    protected $_hidden = [
    	'domain_name',
		'stop_words',
		'courses'
	];
	
    // make virtual fields visible for JSON serialization
	//protected $_virtual = ['course_count'];
    
    protected function _getCourseCount() {
    	return count($this->courses);
	}
}

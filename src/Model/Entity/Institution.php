<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;

/**
 * Institution Entity
 *
 * @property int $id
 * @property int|null $city_id
 * @property int|null $country_id
 * @property string $name
 * @property string|null $description
 * @property string|null $url
 * @property float|null $lon
 * @property float|null $lat
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
        'city_id' => true,
        'country_id' => true,
        'name' => true,
        'description' => true,
        'url' => true,
        'lon' => true,
        'lat' => true,
        'created' => false,
        'updated' => false,
        'city' => true,
        'country' => true,
        'courses' => true,
        'users' => true
    ];
    
    protected $_hidden = [
    	'lon',
		'lat',
		'users',
		'courses'
	];
	
	// make virtual fields visible for JSON serialization
	//protected $_virtual = ['course_count'];
	
	protected function _getCourseCount() {
		return count($this->courses);
	}
}

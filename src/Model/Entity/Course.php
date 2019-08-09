<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Course Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property bool $active
 * @property bool $deleted
 * @property int|null $deletion_reason_id
 * @property bool $approved
 * @property string|null $approval_token
 * @property bool $mod_mailed
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $updated
 * @property \Cake\I18n\FrozenTime|null $last_reminder
 * @property string|null $name
 * @property string|null $description
 * @property int|null $country_id
 * @property int|null $city_id
 * @property int|null $institution_id
 * @property string|null $department
 * @property int|null $course_parent_type_id
 * @property int|null $course_type_id
 * @property int|null $language_id
 * @property string|null $access_requirements
 * @property string|null $start_date
 * @property int|null $duration
 * @property int|null $course_duration_unit_id
 * @property bool $recurring
 * @property string|null $info_url
 * @property string|null $guide_url
 * @property \Cake\I18n\FrozenTime|null $skip_info_url
 * @property \Cake\I18n\FrozenTime|null $skip_guide_url
 * @property float|null $ects
 * @property string|null $contact_mail
 * @property string|null $contact_name
 * @property float|null $lon
 * @property float|null $lat
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\DeletionReason $deletion_reason
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Institution $institution
 * @property \App\Model\Entity\CourseParentType $course_parent_type
 * @property \App\Model\Entity\CourseType $course_type
 * @property \App\Model\Entity\Language $language
 * @property \App\Model\Entity\CourseDurationUnit $course_duration_unit
 * @property \App\Model\Entity\Discipline[] $disciplines
 * @property \App\Model\Entity\TadirahObject[] $tadirah_objects
 * @property \App\Model\Entity\TadirahTechnique[] $tadirah_techniques
 */
class Course extends Entity
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
        'user_id' => true,
        'active' => true,
        'deleted' => false,
        'deletion_reason_id' => true,
        'approved' => false,
        'approval_token' => false,
        'mod_mailed' => false,
        'created' => false,
        'updated' => false,
        'last_reminder' => false,
        'name' => true,
        'description' => true,
        'country_id' => false,
        'city_id' => false,
        'institution_id' => true,
        'department' => true,
        'course_parent_type_id' => false,
        'course_type_id' => true,
        'language_id' => true,
        'access_requirements' => true,
        'start_date' => true,
        'duration' => true,
        'course_duration_unit_id' => true,
        'recurring' => true,
        'info_url' => true,
        'guide_url' => false,
        'skip_info_url' => false,
        'skip_guide_url' => false,
        'ects' => true,
        'contact_mail' => true,
        'contact_name' => true,
        'lon' => true,
        'lat' => true,
        'user' => false,
        'deletion_reason' => true,
        'country' => false,
        'city' => false,
        'institution' => false,
        'course_parent_type' => false,
        'course_type' => false,
        'language' => false,
        'course_duration_unit' => false,
        'disciplines' => false,
        'tadirah_objects' => false,
        'tadirah_techniques' => false
    ];
	
	protected $_hidden = [
		'user_id',
		'approval_token',
		'mod_mailed',
		'last_reminder',
		'guide_url',
		'skip_info_url',
		'skip_guide_url',
		'user'
	];
}

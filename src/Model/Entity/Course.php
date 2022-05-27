<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Course extends Entity
{
    protected $_accessible = [
        'user_id' => true,
        'active' => true,
        'deleted' => true,
        'deletion_reason_id' => true,
        'approved' => true,
        'approval_token' => true,
        'mod_mailed' => true,
        'created' => true,
        'updated' => true,
        'last_reminder' => true,
        'name' => true,
        'description' => true,
        'country_id' => true,
        'city_id' => true,
        'institution_id' => true,
        'department' => true,
        'course_parent_type_id' => true,
        'course_type_id' => true,
        'language_id' => true,
        'access_requirements' => true,
        'start_date' => true,
        'duration' => true,
        'course_duration_unit_id' => true,
        'recurring' => true,
        'online_course' => true,
        'info_url' => true,
        'guide_url' => true,
        'skip_info_url' => true,
        'skip_guide_url' => true,
        'ects' => true,
        'contact_mail' => true,
        'contact_name' => true,
        'lon' => true,
        'lat' => true,
        'user' => true,
        'deletion_reason' => true,
        'country' => true,
        'city' => true,
        'institution' => true,
        'course_parent_type' => true,
        'course_type' => true,
        'language' => true,
        'course_duration_unit' => true,
        'notifications' => true,
        'disciplines' => true,
        'tadirah_activities' => true,
        'tadirah_objects' => true,
        'tadirah_techniques' => true,
    ];
}

<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;


/**
 * User Entity
 *
 * @property int $id
 * @property int $user_role_id
 * @property int|null $country_id
 * @property int|null $institution_id
 * @property string|null $university
 * @property string $email
 * @property string|null $shib_eppn
 * @property string|null $password
 * @property bool $email_verified
 * @property bool $active
 * @property bool $approved
 * @property bool $is_admin
 * @property bool $user_admin
 * @property \Cake\I18n\FrozenTime|null $last_login
 * @property string|null $password_token
 * @property string|null $email_token
 * @property string|null $approval_token
 * @property string|null $new_email
 * @property \Cake\I18n\FrozenTime|null $password_token_expires
 * @property \Cake\I18n\FrozenTime|null $email_token_expires
 * @property \Cake\I18n\FrozenTime|null $approval_token_expires
 * @property string|null $last_name
 * @property string|null $first_name
 * @property string|null $academic_title
 * @property string|null $about
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool $mail_list
 *
 * @property \App\Model\Entity\UserRole $user_role
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Institution $institution
 * @property \App\Model\Entity\Course[] $courses
 */
class User extends Entity
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
        'user_role_id' => true,
        'country_id' => true,
        'institution_id' => true,
        'university' => true,
        'email' => true,
        'shib_eppn' => true,
        'password' => true,
        'email_verified' => true,
        'active' => true,
        'approved' => true,
        'is_admin' => true,
        'user_admin' => true,
        'last_login' => true,
        'password_token' => true,
        'email_token' => true,
        'approval_token' => true,
        'new_email' => true,
        'password_token_expires' => true,
        'email_token_expires' => true,
        'approval_token_expires' => true,
        'last_name' => true,
        'first_name' => true,
        'academic_title' => true,
        'about' => true,
        'created' => true,
        'modified' => true,
        'mail_list' => true,
        'user_role' => true,
        'country' => true,
        'institution' => true,
        'courses' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password) : string
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}

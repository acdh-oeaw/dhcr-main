<?php
namespace App\Model\Entity;

use Authorization\AuthorizationService;
use Authorization\Policy\ResultInterface;
use Authorization\AuthorizationServiceInterface;
use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Authorization\IdentityInterface as AuthorizationIdentity;
use Authentication\IdentityInterface as AuthenticationIdentity;


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
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Institution $institution
 * @property \App\Model\Entity\Course[] $courses
 */
class User extends Entity implements AuthorizationIdentity, AuthenticationIdentity
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
        'country_id' => true,
        'institution_id' => true,
        'university' => true,
        'password' => true,
        'email' => true,
        'new_email' => true,
        'last_name' => true,
        'first_name' => true,
        'academic_title' => true,
        'about' => true,
        'consent' => true,
        'mail_list' => true,
        '*' => false
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




    public function can(string $action, $resource): bool {
        return $this->authorization->can($this, $action, $resource);
    }

    public function canResult(string $action, $resource): ResultInterface {
        return $this->authorization->canResult($this, $action, $resource);
    }

    public function applyScope(string $action, $resource) {
        return $this->authorization->applyScope($this, $action, $resource);
    }

    public function getIdentifier() {
        return $this->id;
    }

    public function getOriginalData() {
        return $this;
    }

    public function setAuthorization(AuthorizationServiceInterface $service)
    {
        $this->authorization = $service;
        return $this;
    }
}

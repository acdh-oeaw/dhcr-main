<?php

namespace App\Model\Entity;

use Authorization\AuthorizationService;
use Authorization\Policy\ResultInterface;
use Authorization\AuthorizationServiceInterface;
use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Authorization\IdentityInterface as AuthorizationIdentity;
use Authentication\IdentityInterface as AuthenticationIdentity;


class User extends Entity implements AuthorizationIdentity, AuthenticationIdentity
{
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

    protected function _setPassword(string $password): string
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }

    public function can(string $action, $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    public function canResult(string $action, $resource): ResultInterface
    {
        return $this->authorization->canResult($this, $action, $resource);
    }

    public function applyScope(string $action, $resource)
    {
        return $this->authorization->applyScope($this, $action, $resource);
    }

    public function getIdentifier()
    {
        return $this->id;
    }

    public function getOriginalData()
    {
        return $this;
    }

    public function setAuthorization(AuthorizationServiceInterface $service)
    {
        $this->authorization = $service;
        return $this;
    }
}

<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\City;
use Authorization\IdentityInterface;

class CityPolicy
{
    public function canAdd(IdentityInterface $user, City $city)
    {
        if(true) {
            return false;
        }
        return false;
    }

    /**
     * Check if $user can edit City
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\City $city
     * @return bool
     */
    public function canEdit(IdentityInterface $user, City $city)
    {
    }

    /**
     * Check if $user can delete City
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\City $city
     * @return bool
     */
    public function canDelete(IdentityInterface $user, City $city)
    {
    }

    /**
     * Check if $user can view City
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\City $city
     * @return bool
     */
    public function canView(IdentityInterface $user, City $city)
    {
    }
}

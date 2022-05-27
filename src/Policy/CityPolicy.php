<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\City;
use Authorization\IdentityInterface;

class CityPolicy
{
    public function canAdd(IdentityInterface $user, City $city)
    {
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }

    public function canEdit(IdentityInterface $user, City $city)
    {
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }
}

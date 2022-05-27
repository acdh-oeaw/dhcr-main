<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Institution;
use Authorization\IdentityInterface;

class InstitutionPolicy
{
    public function canAdd(IdentityInterface $user, Institution $institution)
    {
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }

    public function canEdit(IdentityInterface $user, Institution $institution)
    {
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }

    public function canView(IdentityInterface $user, Institution $institution)
    {
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }
}

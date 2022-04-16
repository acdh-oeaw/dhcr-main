<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\InviteTranslation;
use Authorization\IdentityInterface;

class InviteTranslationPolicy
{
    public function canAdd(IdentityInterface $user, InviteTranslation $inviteTranslation)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canEdit(IdentityInterface $user, InviteTranslation $inviteTranslation)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canView(IdentityInterface $user, InviteTranslation $inviteTranslation)
    {
        // moderators can only view active translations
        if ($user->user_role_id == 2 && $inviteTranslation->active) {
            return true;
        }
        // admin can view everything
        if ($user->is_admin) {   // moderators can view only
            return true;
        }
        return false;
    }
}

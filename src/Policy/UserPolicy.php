<?php

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class UserPolicy
{
    // approval check
    public function canAccessDashboard(IdentityInterface $user, $data = [])
    {
        $user = $user->getOriginalData();
        if ($user->email_verified && $user->approved) {
            return true;
        }
        return false;
    }

    public function canApprove(IdentityInterface $user, IdentityInterface $approvingUser)
    {
        // moderator can approve in moderated country
        if ($user->user_role_id == 2 && ($approvingUser->country_id == $user->country_id)) {
            return true;
        }
        // admin can approve all
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canView(IdentityInterface $user, IdentityInterface $viewedUser)
    {
        // moderator can view in own country
        if ($user->user_role_id == 2 && ($viewedUser->country_id == $user->country_id)) {
            return true;
        }
        // admin can view all
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canEdit(IdentityInterface $user, IdentityInterface $editUser)
    {
        // moderator can edit in own country
        if ($user->user_role_id == 2 && ($editUser->country_id == $user->country_id)) {
            return true;
        }
        // admin can edit all
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canInvite(IdentityInterface $user, IdentityInterface $viewedUser)
    {
        // moderator and admin can both invite
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }

    public function canReInvite(IdentityInterface $user, IdentityInterface $inviteUser)
    {
        // moderator can reinvite in own country
        if ($user->user_role_id == 2 && ($inviteUser->country_id == $user->country_id)) {
            return true;
        }
        // admin can reinvite all
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canModeratorFaq(IdentityInterface $user, IdentityInterface $viewedUser)
    {
        // only for mod and admin
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }

    public function canUsersAccessWorkflows(IdentityInterface $user, IdentityInterface $viewedUser)
    {
        // only for mod and admin
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }

    public function canPendingInvitations(IdentityInterface $user)
    {
        // both mod and admin can see their list
        if ($user->user_role_id == 2 || $user->is_admin) {
            return true;
        }
        return false;
    }

    public function canSummaryStatistics(IdentityInterface $user)
    {
        // only for admin
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canCourseStatistics(IdentityInterface $user)
    {
        // only for admin
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canUserStatistics(IdentityInterface $user)
    {
        // only for admin
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canAppInfo(IdentityInterface $user)
    {
        // only for admin
        if ($user->is_admin) {
            return true;
        }
        return false;
    }


    public function canModerators(IdentityInterface $user)
    {
        // only for admin
        if ($user->is_admin) {
            return true;
        }
        return false;
    }
}

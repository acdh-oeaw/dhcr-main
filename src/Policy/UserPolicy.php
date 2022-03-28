<?php
namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;

class UserPolicy
{
    // approval check
    public function canAccessDashboard(IdentityInterface $user, $data = []) : Result
    {
        $user = $user->getOriginalData();
        if($user->email_verified && $user->approved)
            return new Result(true);
        return new Result(false, 'User not approved');
    }

    public function canEditCourse(IdentityInterface $user, $course = []) : Result
    {
        $user = $user->getOriginalData();
        if($course->user_id == $user->id) {     // User is editing own course
            return new Result(true);
        }
        if ( ($user->user_role_id == 2) && ($course->country_id == $user->country_id) ) { // Moderator is editing in moderated country
            return new Result(true);
        }
        if ($user->is_admin) {    //  Admin can edit everything
            return new Result(true);
        }
        return new Result(true, 'You are not allowed to edit this course');
    }
}
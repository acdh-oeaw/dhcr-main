<?php
namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;

class UserPolicy
{
    public function canAccessDashboard(IdentityInterface $user, $data = []) : Result
    {
        $user = $user->getOriginalData();
        if($user->email_verified && $user->approved)
            return new Result(true);
        return new Result(false, 'User not approved');
    }
}

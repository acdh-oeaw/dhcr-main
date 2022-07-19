<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Logentry;
use Authorization\IdentityInterface;

class LogentryPolicy
{
    public function canView(IdentityInterface $user, Logentry $logentry)
    {
        // only for admin
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canEdit(IdentityInterface $user, Logentry $logentry)
    {
        // to be implemented later for "clearing" a log entry, then only for admin
        return false;
    }
}

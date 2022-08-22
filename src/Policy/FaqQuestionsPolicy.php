<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\faqQuestions;
use Authorization\IdentityInterface;

class faqQuestionsPolicy
{
    public function canAdd(IdentityInterface $user)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }
    public function canEdit(IdentityInterface $user)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canView(IdentityInterface $user)
    {
        // TODO: change
        if ($user->is_admin) {
            return true;
        }
        return false;
    }
}

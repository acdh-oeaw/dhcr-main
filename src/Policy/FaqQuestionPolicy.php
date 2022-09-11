<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\FaqQuestion;
use Authorization\IdentityInterface;

class FaqQuestionPolicy
{
    public function canAdd(IdentityInterface $user, FaqQuestion $faqQuestion)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canEdit(IdentityInterface $user, FaqQuestion $faqQuestion)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canView(IdentityInterface $user, FaqQuestion $faqQuestion)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canMoveUp(IdentityInterface $user, FaqQuestion $faqQuestion)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canMoveDown(IdentityInterface $user, FaqQuestion $faqQuestion)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }
}

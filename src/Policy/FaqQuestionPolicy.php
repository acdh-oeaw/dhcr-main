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

    public function canFaqList(IdentityInterface $user, FaqQuestion $faqQuestion)
    {
        // admin and moderator can access all
        if ($user->is_admin || $user->user_role_id == 2) {
            return true;
        }
        // contributor can only access contributor-faq
        if ($user->user_role_id == 3 && $faqQuestion->faq_category_id == 2) {
            return true;
        }
        return false;
    }
}

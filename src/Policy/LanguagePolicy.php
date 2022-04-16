<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Language;
use Authorization\IdentityInterface;

class LanguagePolicy
{
    public function canAdd(IdentityInterface $user, Language $language)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }

    public function canEdit(IdentityInterface $user, Language $language)
    {
        if ($user->is_admin) {
            return true;
        }
        return false;
    }
}

<?php

namespace App\Authenticator;

use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;

class AppResult extends Result implements ResultInterface {
	// partial success: we have external authentication, but no internal user with that ID
    public const NEW_EXTERNAL_IDENTITY = 'NEW_EXTERNAL_IDENTITY';


    public function isValid(): bool
    {
        if($this->_status === self::NEW_EXTERNAL_IDENTITY)
            return false;
        parent::isValid();
    }
}

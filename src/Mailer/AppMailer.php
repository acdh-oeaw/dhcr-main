<?php

namespace App\Mailer;

use Cake\Mailer\Mailer;

class AppMailer extends Mailer {

    public function setSubject(String $subject) : Mailer {
        return parent::setSubject(sprintf('[DH Course Registry] %s', $subject));
    }
}

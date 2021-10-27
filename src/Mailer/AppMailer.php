<?php

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class AppMailer extends Mailer {

    public function __construct($config = null) {
        parent::__construct($config);
        $this->setDomain(Configure::read('dhcr.baseUrl'));
    }

    public function setSubject(String $subject) : Mailer {
        return parent::setSubject(sprintf('[DH Course Registry] %s', $subject));
    }
}

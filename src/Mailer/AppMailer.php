<?php

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Mailer\Transport\DebugTransport;

class AppMailer extends Mailer
{

    public function __construct($config = null)
    {
        parent::__construct($config);
        $this->setDomain(Configure::read('dhcr.baseUrl'));
    }

    public function setSubject(String $subject): Mailer
    {
        return parent::setSubject(sprintf('[DH Course Registry] %s', $subject));
    }

    public function preventMailbombing($to)
    {
        if (Configure::read('debug')) {
            // prevent mailbombing
            $debugmail = env('DEBUG_MAIL_TO', false);
            if ($debugmail) {
                return $debugmail;
            } else {
                $this->setTransport(new DebugTransport());
            }
        }
        return $to;
    }
}

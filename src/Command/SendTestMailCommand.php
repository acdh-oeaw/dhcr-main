<?php

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Mailer\Mailer;

/***
 * Sends a test email to the debug mailaddress. Can be used for debugging problems with sending mails.
 * Not needed for other parts of the application.
 */

class SendTestMailCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('~~~ Started Send Test Mail ~~~');

        $from = env('APP_MAIL_DEFAULT_FROM');
        $to = env('DEBUG_MAIL_TO');
        $subject = '[DH Course Registry] Test Mail';

        $mailer = new Mailer('default');
        $mailer->setFrom([$from => 'DHCR test'])
            ->setTo($to)
            ->setSubject($subject)
            ->deliver('My message');

        $io->out('~~~ Finished Send Test Mail ~~~');
    }
}

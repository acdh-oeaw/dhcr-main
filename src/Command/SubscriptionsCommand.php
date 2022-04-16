<?php

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Log\Log;

class SubscriptionsCommand extends Command
{

    public $Subscriptions;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Subscriptions');
    }


    public function execute(Arguments $args, ConsoleIo $io)
    {
        $result = $this->Subscriptions->processSubscriptions();
        $message = 'Success Quote: ' . $result['courses'] . '/' . $result['subscriptions'] . '.\n'
            . 'Processed ' . $result['subscriptions'] . ' subscriptions, '
            . $result['courses'] . ' got a notification about new courses';
        Log::write('info', $message, ['cron']);
    }
}

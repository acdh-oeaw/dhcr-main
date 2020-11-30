<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;

class SubscriptionsCommand extends Command
{

    public $Subscriptions;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Subscriptions');
    }


    public function execute(Arguments $args, ConsoleIo $io)
    {
        $result = $this->Subscriptions->processSubscriptions();
        $io->out('Processed '.$result.' subscriptions.');
    }
}

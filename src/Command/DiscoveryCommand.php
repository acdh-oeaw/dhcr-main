<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;

class DiscoveryCommand extends Command
{

    public function initialize() : void
    {
        parent::initialize();
    }


    public function execute(Arguments $args, ConsoleIo $io)
    {
        $source = 'https://acdh.oeaw.ac.at/Shibboleth.sso/DiscoFeed';
        $_destination = WWW_ROOT.'js/idp_select/_DiscoFeed.json';
        $destination = WWW_ROOT.'js/idp_select/DiscoFeed.json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:54.0) Gecko/20100101 Firefox/54.0');
        $discoFeed = curl_exec($ch);
        $discoFeed = preg_replace( "/\r|\n/", "", $discoFeed);
        file_put_contents($_destination, $discoFeed);
        curl_close($ch);
        rename($_destination, $destination);

        $io->out('Downloaded discovery feed JSON file.');
    }
}

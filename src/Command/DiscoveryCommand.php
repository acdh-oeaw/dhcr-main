<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Log\Log;

class DiscoveryCommand extends Command
{

    public function initialize() : void
    {
        parent::initialize();
    }


    public function execute(Arguments $args, ConsoleIo $io)
    {
        $source = 'https://acdh.oeaw.ac.at/Shibboleth.sso/DiscoFeed';
        $destination = WWW_ROOT.'js/idp_select/DiscoFeed.json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:54.0) Gecko/20100101 Firefox/54.0');
        $discoFeed = curl_exec($ch);
        curl_close($ch);

        $discoFeed = json_decode($discoFeed, true);
        $discoObject = [];
        // removing doublettes and creating identifier index
        foreach($discoFeed as $entity) $discoObject[$entity['entityID']] = $entity;
        // sort multibyte-aware by display name
        uasort($discoObject, [$this,"__cmp"]);
        $io->createFile($destination, json_encode($discoObject, JSON_UNESCAPED_SLASHES), true);
        Log::write('info', 'Downloaded discovery feed JSON file', ['cron']);
    }


    private function __cmp ($a,$b) {
        $a = $this->__getDisplayName($a);
        $b = $this->__getDisplayName($b);

        $alphabet = "AaÀàÁáÂâÅåÃãÄäÆæBbCcÇçDdÐðEeÈèÉéÊêËëFfGgHhIiÌìÍíÎîÏïJjKkLlMmNnÑñOoÒòÓóÔôÕõÖöØøPpQqRrSsßŠšTtUuÙùÚúÛûÜüVvWwXxYyŸÿÝýZzŽžÞþ0123456789";
        $l1 = mb_strlen($a);
        $l2 = mb_strlen($b);
        $c = min($l1, $l2);

        for ($i = 0; $i < $c; $i++)
        {
            $s1 = mb_substr($a, $i, 1);
            $s2 = mb_substr($b, $i, 1);
            if ($s1===$s2) continue;
            $i1 = mb_strpos($alphabet, $s1);
            if ($i1===false) continue;
            $i2 = mb_strpos($alphabet, $s2);
            if ($i2===false) continue;


            if ($i2===$i1) continue;
            if ($i1 < $i2) return -1;
            else return 1;
        }
        if ($l1 < $l2) return -1;
        elseif ($l1 > $l2) return 1;
        return 0;
    }


    private function __getDisplayName($entity) {
        if(!empty($entity['DisplayNames'])
            AND count($entity['DisplayNames']) >= 1) {
            foreach($entity['DisplayNames'] as $displayName) {
                if($displayName['lang'] == 'en')
                    return $displayName['value'];
            }
            return $entity['DisplayNames'][0]['value'];
        }else{
            // in some cases there are no display names, just the Id (an URI)
            return $entity['entityID'];
        }
    }
}

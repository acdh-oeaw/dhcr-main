<?php
use Cake\Routing\Router;
use Cake\Core\Configure;

$id = ($this->request->getParam('action') == 'view' AND !empty($this->request->getParam('pass')))
    ? $this->request->getParam('pass')[0]
    : 'false';
?>

<script type="application/javascript">
    'use strict';
    
    var BASE_URL = '<?= Router::url('/', true) ?>';
    
    var app;
    
    <?php
    $jsonOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PARTIAL_OUTPUT_ON_ERROR;
    if(!empty($courses))
        echo 'var courses = ' . json_encode($courses, $jsonOptions). ';';
    if(!empty($course))
        echo 'var course = ' . json_encode($course, $jsonOptions) . ';';
    if(!empty($countries))
        echo 'var countries = ' . json_encode($countries, $jsonOptions). ';';
    if(!empty($cities))
        echo 'var cities = ' . json_encode($cities, $jsonOptions). ';';
    if(!empty($institutions))
        echo 'var institutions = ' . json_encode($institutions, $jsonOptions). ';';
    if(!empty($languages))
        echo 'var languages = ' . json_encode($languages, $jsonOptions). ';';
    if(!empty($types))
        echo 'var types = ' . json_encode($types, $jsonOptions). ';';
    if(!empty($disciplines))
        echo 'var disciplines = ' . json_encode($disciplines, $jsonOptions). ';';
    if(!empty($techniques))
        echo 'var techniques = ' . json_encode($techniques, $jsonOptions). ';';
    if(!empty($objects))
        echo 'var objects = ' . json_encode($objects, $jsonOptions). ';';
    
    ?>

    $(document).ready( function() {

        app = new App({
            mapApiKey:  '<?= Configure::read('map.apiKey') ?>',
            apiUrl:     '<?= Configure::read('api.baseUrl') ?>',
            action:     '<?= $this->request->getParam('action') ?>',
            id:          <?= $id ?>
        });

    });
    
    // modal handlers need to be called only once
    Modal.addHandlers();
</script>

<script type="text/javascript">
    var _paq = _paq || [];
    // tracker methods like "setCustomDimension" should be called before "trackPageView"
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);

    (function() {
        var u="//matomo.acdh.oeaw.ac.at/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '21']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>

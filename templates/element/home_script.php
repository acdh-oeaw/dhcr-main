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

        let app = new App({
            mapApiKey:  '<?= Configure::read('map.apiKey') ?>',
            apiUrl:     '<?= Configure::read('api.baseUrl') ?>',
            action:     '<?= $this->request->getParam('action') ?>',
            id:          <?= $id ?>
        });

        if($('.flash-message').length) {
            $('.flash-message').slideDown('fast').delay(8000).fadeOut('slow');
        }

        let sitemap = new Sitemap();
        $(document).on('click', '#menu-button', function(e) {
            sitemap.show(e);
        });
    });
</script>

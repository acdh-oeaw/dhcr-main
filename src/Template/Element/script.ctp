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
        echo 'var json_courses = ' . json_encode($courses, $jsonOptions). ';';
    
    ?>

    $(document).ready( function() {

        app = new App({
            mapApiKey:  '<?= Configure::read('map.apiKey') ?>',
            apiUrl:     '<?= Configure::read('api.baseUrl') ?>',
            action:     '<?= $this->request->getParam('action') ?>',
            id:          <?= $id ?>
        });

    });


</script>

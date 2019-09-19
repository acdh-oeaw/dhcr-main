<?php
use Cake\Routing\Router;
use Cake\Core\Configure;
?>

<script type="application/javascript">
    'use strict';
    
    var base_url = '<?= Router::url('/', true) ?>';
    var map_api_key = '<?= Configure::read('map.apiKey') ?>';
    var api_base_url = '<?= Configure::read('api.baseUrl') ?>';
    
    var app;

    $(document).ready( function() {

        app = new App({
            mapApiKey: map_api_key,
            apiBaseUrl: api_base_url
        });

    });


</script>

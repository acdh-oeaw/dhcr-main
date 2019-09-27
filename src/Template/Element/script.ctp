<?php
use Cake\Routing\Router;
use Cake\Core\Configure;

$id = ($this->request->params['action'] == 'view' AND !empty($this->request->params['pass']))
    ? $this->request->params['pass'][0]
    : 'false';
?>

<script type="application/javascript">
    'use strict';
    
    var BASE_URL = '<?= Router::url('/', true) ?>';
    
    var app;

    $(document).ready( function() {

        app = new App({
            mapApiKey:  '<?= Configure::read('map.apiKey') ?>',
            apiUrl:     '<?= Configure::read('api.baseUrl') ?>',
            view:       '<?= $this->request->params['action'] ?>',
            id:          <?= $id ?>
        });

    });


</script>

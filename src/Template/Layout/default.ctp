<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;
use Cake\Routing\Router;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <meta property="og:url"           content="<?= Router::url('/', true) ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="The Digital Humanities Course Registry" />
        <meta property="og:description"   content="The Digital Humanities Course Registry is a curated platform that provides an overview of the growing range of teaching activities in the field of digital humanities worldwide." />
        <meta property="og:image"         content="<?= Router::url('/android-chrome-192x192.png', true) ?>" />
        
        <?= $this->Html->css('styles.css') ?>
        <?= $this->Html->css('/leaflet/leaflet.css') ?>
        
        
        <title>Digital Humanities Course Registry</title>
    
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Router::url('/apple-touch-icon.png?v=kPv24zPR6') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Router::url('/favicon-32x32.png?v=kPv24zPR6') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Router::url('/favicon-16x16.png?v=kPv2PR6') ?>">
        <link rel="manifest" href="<?= Router::url('/site.webmanifest?v=kPv24zPR6') ?>">
        <link rel="mask-icon" href="<?= Router::url('/safari-pinned-tab.svg?v=kPv24zPR6') ?>" color="#5bbad5">
        <link rel="shortcut icon" href="<?= Router::url('/favicon.ico?v=kP4zPR6') ?>">
        <meta name="msapplication-TileColor" content="#00aba9">
        <meta name="theme-color" content="#ffffff">
        
    </head>
    
    <body class="<?= $this->request->getParam('action') ?>">
        <div id="header">
            <div id="logo">
                <?= $this->Html->image('logo-300.png', [
                    'url' => '/',
                    'alt' => 'Digital Humanities Course Registry (logo)'
                ]); ?>
            </div>
            <div id="menu">
                <?= $this->Html->link('Info', '/pages/info', ['class' => 'blue button', 'id' => 'info-button']) ?>
                <?= $this->Html->link('Login', Configure::read('ops.baseUrl').'users/login',
                    ['class' => 'button', 'id' => 'login-button']) ?>
            </div>
        </div>
        
        <div id="container">
            
            <?= $this->fetch('content') ?>
        
        </div>
        
        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <?= $this->Html->script('jquery-3.4.1.min.js') ?>
        
        <!-- https://github.com/js-cookie/js-cookie -->
        <!--<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>-->
        <?= $this->Html->script('cookie') ?>
        
        <!--<script src="<?= Router::url('/leaflet/leaflet.js', true) ?>" type="application/javascript"></script>-->
        <?= $this->Html->script('/leaflet/leaflet') ?>
        <!--<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>-->
        <?= $this->Html->script('/leaflet/leaflet.markercluster') ?>
        
        <?= $this->Html->script(['scroll','hash','slide','sharing','map','modal',
            'sort','filter','filter_helper','view','view_helper','app']) ?>
        
        <?= $this->element('script') ?>
    
    </body>
</html>

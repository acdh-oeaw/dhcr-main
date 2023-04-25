<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Element('meta') ?>
    <?= $this->Html->css('home.css') ?>
    <?= $this->Html->css('/leaflet/leaflet.css') ?>
</head>

<body class="dhcr-home <?= $this->request->getParam('action') ?>">
    <div id="page-head">
        <div id="logo">
            <?= $this->Html->image('logo-300.png', [
                'url' => '/',
                'alt' => 'Digital Humanities Course Registry (logo)'
            ]); ?>
        </div>
        <div id="menu">
            <?= $this->Html->link('Info', '/info', ['class' => 'blue button', 'id' => 'info-button']) ?>
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-menu-hamburger">Menu</span>',
                '/pages/sitemap',
                [
                    'class' => 'button',
                    'id' => 'menu-button',
                    'escape' => false,
                    'title' => 'Menu'
                ]
            ) ?>
        </div>
        <?= $this->element('sitemap') ?>
    </div>
    <div id="container">
        <?= $this->fetch('content') ?>
    </div>
    <?= $this->Html->script('jquery-3.6.4.min.js') ?>
    <?= $this->Html->script('typeahead.bundle.js') ?>
    <style>
        .bs-example {
            font-family: sans-serif;
            position: relative;
            margin: 100px;
        }

        .typeahead,
        .tt-query,
        .tt-hint {
            border: 2px solid #CCCCCC;
            border-radius: 8px;
            font-size: 14px;
            /* Set input font size */
            height: 30px;
            line-height: 30px;
            outline: medium none;
            padding: 8px 12px;
            width: 422px;
        }

        .typeahead {
            background-color: #FFFFFF;
        }

        .typeahead:focus {
            border: 2px solid #0097CF;
        }

        .tt-query {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        }

        .tt-hint {
            color: #999999;
        }

        .tt-menu {
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            margin-top: 12px;
            padding: 8px 0;
            width: 422px;
        }

        .tt-suggestion {
            font-size: 14px;
            /* Set suggestion dropdown font size */
            padding: 3px 20px;
        }

        .tt-suggestion:hover {
            cursor: pointer;
            background-color: #0097CF;
            color: #FFFFFF;
        }

        .tt-suggestion p {
            margin: 0;
        }
    </style>
    <?= $this->Flash->render('flash') ?>
    <?= $this->Html->script('/leaflet/leaflet') ?>
    <?= $this->Html->script('/leaflet/leaflet.markercluster') ?>
    <?= $this->Html->script([
        'scroll', 'hash', 'slide', 'sharing', 'map', 'modal',
        'sitemap', 'filter', 'filter_helper', 'view', 'view_helper', 'app'
    ]) ?>
    <?php
    $id = ($this->request->getParam('action') == 'view' and !empty($this->request->getParam('pass')))
        ? $this->request->getParam('pass')[0]
        : 'false';
    ?>
    <script type="application/javascript">
        'use strict';
        var BASE_URL = '<?= Router::url('/', true) ?>';
        var app;
        <?php
        $jsonOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PARTIAL_OUTPUT_ON_ERROR;
        if (!empty($courses))
            echo 'var courses = ' . json_encode($courses, $jsonOptions) . ';';
        if (!empty($course))
            echo 'var course = ' . json_encode($course, $jsonOptions) . ';';
        if (!empty($countries))
            echo 'var countries = ' . json_encode($countries, $jsonOptions) . ';';
        if (!empty($cities))
            echo 'var cities = ' . json_encode($cities, $jsonOptions) . ';';
        if (!empty($institutions))
            echo 'var institutions = ' . json_encode($institutions, $jsonOptions) . ';';
        if (!empty($languages))
            echo 'var languages = ' . json_encode($languages, $jsonOptions) . ';';
        if (!empty($types))
            echo 'var types = ' . json_encode($types, $jsonOptions) . ';';
        if (!empty($disciplines))
            echo 'var disciplines = ' . json_encode($disciplines, $jsonOptions) . ';';
        if (!empty($techniques))
            echo 'var techniques = ' . json_encode($techniques, $jsonOptions) . ';';
        if (!empty($objects))
            echo 'var objects = ' . json_encode($objects, $jsonOptions) . ';';
        ?>
        $(document).ready(function() {
            let app = new App({
                mapApiKey: '<?= Configure::read('map.apiKey') ?>',
                apiUrl: '<?= Configure::read('api.baseUrl') ?>',
                action: '<?= $this->request->getParam('action') ?>',
                id: <?= $id ?>
            });
            if ($('.flash-message').length) {
                $('.flash-message').slideDown('fast').delay(8000).fadeOut('slow');
            }
            let sitemap = new Sitemap();
            $(document).on('click', '#menu-button', function(e) {
                sitemap.show(e);
            });
        });
    </script>
    <?= $this->element('matomo') ?>
</body>

</html>

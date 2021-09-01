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
                    '/pages/sitemap', [
                        'class' => 'button',
                        'id' => 'menu-button',
                        'escape' => false,
                        'title' => 'Menu'
                ]) ?>
            </div>
            <?= $this->element('sitemap') ?>
        </div>

        <div id="container">

            <?= $this->fetch('content') ?>

        </div>
        <?= $this->Flash->render('flash') ?>

        <?= $this->Html->script('jquery-3.4.1.min.js') ?>

        <?= $this->Html->script('/leaflet/leaflet') ?>
        <?= $this->Html->script('/leaflet/leaflet.markercluster') ?>

        <?= $this->Html->script(['scroll','hash','slide','sharing','map','modal',
            'sitemap','filter','filter_helper','view','view_helper','app']) ?>

        <?= $this->element('home_script') ?>

        <?= $this->element('matomo') ?>

    </body>
</html>

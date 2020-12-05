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

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->Element('meta') ?>

        <?= $this->Html->css('styles.css') ?>
        <?= $this->Html->css('/leaflet/leaflet.css') ?>
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
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-envelope"></span><span class="glyphicon glyphicon-bell"></span>',
                    '/subscriptions/add', [
                        'class' => 'blue button',
                        'id' => 'notification-button',
                        'escape' => false
                ]) ?>
                <?= $this->Html->link('Stories', '/stories', ['class' => 'blue button', 'id' => 'story-button']) ?>
                <?= $this->Html->link('Info', '/info', ['class' => 'blue button', 'id' => 'info-button']) ?>
                <?= $this->Html->link('Login', Configure::read('ops.baseUrl').'users/login',
                    ['class' => 'button', 'id' => 'login-button']) ?>
            </div>
        </div>

        <div id="container">

            <?= $this->fetch('content') ?>

        </div>

        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <?= $this->Html->script('jquery-3.4.1.min.js') ?>

        <!--<script src="<?= Router::url('/leaflet/leaflet.js', true) ?>" type="application/javascript"></script>-->
        <?= $this->Html->script('/leaflet/leaflet') ?>
        <!--<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>-->
        <?= $this->Html->script('/leaflet/leaflet.markercluster') ?>

        <?= $this->Html->script(['scroll','hash','slide','sharing','map','modal',
            'filter','filter_helper','view','view_helper','app']) ?>

        <?= $this->element('script') ?>

        <?= $this->element('matomo') ?>

    </body>
</html>

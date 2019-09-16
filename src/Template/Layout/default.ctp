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
        
        <?= $this->Html->css('styles.css') ?>
        <?= $this->Html->css('/leaflet/leaflet.css') ?>
        
        
        <title>Digital Humanities Course Registry</title>
        <?= $this->Html->meta('icon') ?>
    </head>
    
    <body class="home">
        <div id="overlay">
            <div class="overlay-container">
               <h1>
                    <a href="<?= Router::url('/') ?>">
                        <span id="h1">Digital Humanities</span><br>
                        <span id="h2">Course</span><span id="h3">Registry</span>
                    </a>
                </h1>
                <?= $this->Html->link($this->Html->image('CLARIN-DARIAH-joint-logo-big.png', [
                    'alt' => 'CLARIN-DARIAH joint logo',
                    'width' => 256,
                    'height' => 200]), '/', ['escape' => false, 'class' => 'img']) ?>
                <p>
                    The Digital Humanities Course Registry is a joint effort of two
                    European research infrastructures:
                    <em>CLARIN ERIC</em> and <em>DARIAH-EU</em>.
                </p>
                <p>
                    It provides a curated database of teaching activities in the
                    field of digital humanities worldwide.
                </p>
            </div>
            <div class="overlay-container transparent"></div>
            <div class="overlay-container flex-columns">
                <div class="flex-item">
                    <h2>Students</h2>
                    <p>
                        Students can find information about programmes and courses
                        in digital humanities offered in various places and universities.
                    </p>
                </div>
                <div class="flex-item">
                    <h2>Lecturers</h2>
                    <p>
                        Lecturers or administrators can promote their teaching
                        activities on the platform. <br />
                        To add data, lecturers need to sign in.
                    </p>
                </div>
            </div>
            <div class="overlay-container flex-columns">
                <div class="flex-item"><button class="blue">Go to Start</button></div>
                <div class="flex-item"><button>More Information</button></div>
            </div>
        </div>
        <div id="header">
            <div id="logo">
                <?= $this->Html->link($this->Html->image('CLARIN-DARIAH-joint-logo.jpg', [
                    'alt' => 'CLARIN-DARIAH joint logo',
                    'width' => 115,
                    'height' => 90]), '/', ['escape' => false, 'class' => 'img']) ?>
                <div class="title">
                    <h1>
                        <a href="<?= Router::url('/') ?>">
                            <span id="h1">Digital Humanities</span><br>
                            <span id="h2">Course</span><span id="h3">Registry</span>
                        </a>
                    </h1>
                </div>
            </div>
            <div id="menu">
                <button class="blue" id="info-button">Info</button>
                <button id="login-button">Login</button>
            </div>
        </div>
        
        <div id="container">
            
            <?= $this->fetch('content') ?>
        
        </div>
        
        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <script src="<?= Router::url('/js/jquery-3.4.1.min.js', true) ?>" type="application/javascript"></script>
        
        <script src="<?= Router::url('/leaflet/leaflet.js', true) ?>" type="application/javascript"></script>
        <!--<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>-->
        <script src="<?= Router::url('/leaflet/leaflet.markercluster.js', true) ?>" type="application/javascript"></script>
        <script src="<?= Router::url('/js/scroll.js', true) ?>" type="application/javascript"></script>
        <script src="<?= Router::url('/js/slide.js', true) ?>" type="application/javascript"></script>
        <script src="<?= Router::url('/js/map.js', true) ?>" type="application/javascript"></script>
        <script src="<?= Router::url('/js/table.js', true) ?>" type="application/javascript"></script>
        <script src="<?= Router::url('/js/app.js', true) ?>" type="application/javascript"></script>
        <script src="<?= Router::url('/js/home.js', true) ?>" type="application/javascript"></script>
    </body>
</html>

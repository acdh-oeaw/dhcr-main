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

$this->layout = false;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <?= $this->Html->css('info.css') ?>
        
        
        <title>DH Course Registry - Information</title>
        <?= $this->Html->meta('icon') ?>
    </head>
    <body class="info">
        <div id="page-head">
            <h1>
                <a href="<?= Router::url('/') ?>">
                    <span id="h1">Digital Humanities</span><br>
                    <span id="h2">Course</span><span id="h3">Registry</span>
                </a>
            </h1>
            
            <p>
                The Digital Humanities Course Registry (DHCR) provides a curated database
                of teaching activities in the field of digital humanities worldwide.
            </p>
        </div>
        
        
        
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
            <div class="flex-item"><button class="blue" id="start">Go to Start</button></div>
            <div class="flex-item"><button>More Information</button></div>
        </div>
    </body>
</html>

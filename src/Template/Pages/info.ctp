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
            <?= $this->Html->link('Back to Start', '/', ['class' => 'blue back button']); ?>
            <h1>
                <a href="<?= Router::url('/') ?>">
                    <span id="h1">Digital Humanities</span><br>
                    <span id="h2">Course</span><span id="h3">Registry</span>
                </a>
            </h1>
            <p class="intent">
                The Digital Humanities Course Registry (DHCR) provides a curated database
                of teaching activities in the field of digital humanities worldwide.
            </p>
        </div>
        
        
        
        <div id="accordeon">
            <div class="accordeon-item" id="how-to-use">
                <h2>How to Use</h2>
                <div class="item-content">
                    <?= $this->Element('info/how_to_use') ?>
                </div>
            </div>
    
            <div class="accordeon-item" id="contact">
                <h2>Contact Us</h2>
                <div class="item-content">
                    <?= $this->Element('info/contact'); ?>
                </div>
            </div>
    
            <div class="accordeon-item" id="downloads">
                <h2>Publications and Data</h2>
                <div class="item-content">
                    <?= $this->Element('info/downloads') ?>
                </div>
            </div>
    
            <div class="accordeon-item" id="clarin-dariah">
                <h2>CLARIN and DARIAH</h2>
                <div class="item-content">
                    <?= $this->Element('info/clarin-dariah') ?>
                </div>
            </div>
    
            <div class="accordeon-item" id="credits">
                <h2>Credits</h2>
                <div class="item-content">
                    <?= $this->Element('info/credits'); ?>
                </div>
            </div>

            <div class="accordeon-item" id="imprint">
                <h2>Imprint</h2>
                <div class="item-content" id="imprint-content"></div>
            </div>
            
        </div>
        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <?= $this->Html->script('jquery-3.4.1.min.js') ?>
        <?= $this->Html->script(['accordeon', 'cookie']) ?>
        
        <script type="application/javascript">
            $(document).ready( function() {
                Cookies.set('hideIntro', 'true', {expires: 365});
                new Accordeon('accordeon');
                $('#imprint-content').load('https://shared.acdh.oeaw.ac.at/acdh-common-assets/api/imprint.php?serviceID=7435');
            });
        </script>
    </body>
</html>

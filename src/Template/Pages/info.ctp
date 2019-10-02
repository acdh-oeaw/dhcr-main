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
                The Digital Humanities Course Registry provides a curated database
                of teaching activities in the field of digital humanities worldwide.
            </p>
        </div>
        
        
        
        <div id="accordeon">
            <div class="accordeon-item">
                <h2>How to Use</h2>
                <div class="item-content">
                    <div class="flex-columns">
                        <div class="flex-item">
                            <?= $this->Html->image('students.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
                            <h3>Students</h3>
                            <p>
                                Starting a university programme in digital humanities
                                or want to study one semester abroad,
                                students can find information about programmes
                                and courses offered in various places and universities.
                            </p>
                            <p>
                                The collection of courses and programs can be searched without registration.
                                To hold only useful and most up-to-date content, all data in the DHCR
                                is actively maintained by the lecturers or departments themselves.
                                Courses can be searched based on location, disciplines, research techniques
                                or objects and degrees awarded.
                            </p>
                            <p>
                                Historical data or very specific queries can be retrieved using
                                the open DHCR-API for research or programme decisions.
                                The DHCR is collecting course data starting from 2014.
                            </p>
                        </div>
                        <div class="flex-item">
                            <?= $this->Html->image('lecturers.png', ['class' => 'illustration', 'alt' => 'illustration']); ?>
                            <h3>Lecturers</h3>
                            <p>
                                Lecturers or progamm administrators can promote their DH-related
                                teaching activities on the Digital Humanities Course Registry.
                                To add data, lecturers need to sign in. We require all data
                                contributors to actively maintain their data at least once per year.
                            </p>
                            <p>
                                The system will regularly send out email reminders, whenever a data set
                                is about to expire. Course data not revised for one and half a year
                                will disappear from the public listing and remains archived
                                for later research. The system also performs regular link checking
                                on URLs provided with the data.
                            </p>
                            <div class="buttons">
                                <button id="login">Login</button>
                                <button id="register" class="blue">Register</button>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="flex-columns">
                        <div class="flex-item triple">
                            <h4>The Course Registry</h4>
                            <div class="iframe-container">
                                <?= $this->Html->image('16x9.png', ['class' => 'ratio']) ?>
                                <iframe src="https://www.youtube.com/embed/pvFKq67-21I?rel=0"
                                    allow="encrypted-media" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="flex-item triple">
                            <h4>How to use as a Student</h4>
                            <div class="iframe-container">
                                <?= $this->Html->image('16x9.png', ['class' => 'ratio']) ?>
                                <iframe src="https://www.youtube.com/embed/78TwdVY3LRc?rel=0"
                                    allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="flex-item triple">
                            <h4>How to use as a Lecturer</h4>
                            <div class="iframe-container">
                                <?= $this->Html->image('16x9.png', ['class' => 'ratio']) ?>
                                <iframe src="https://www.youtube.com/embed/p_X7K2b1D9g?rel=0"
                                    allow="encrypted-media" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="accordeon-item">
                <h2>Technical Documentation</h2>
                <div class="item-content">
                
                </div>
            </div>
    
            <div class="accordeon-item">
                <h2>CLARIN & DARIAH</h2>
                <div class="item-content">
                    <p>
                        Creating opportunities for collaboration across disciplines and borders
                        is a key feature of research infrastructures.
                        As such, CLARIN and DARIAH offer platforms, conferences and workshops,
                        where researchers from various countries and disciplines meet each other.
                    </p>
                    <p>
                        Within DARIAH, a number of working groups has been established about
                        strategic areas such as Artificial Intelligence and Music, GeoHumanities or
                        Women Writers in History. These working groups form a vital link between
                        the infrastructure and the scientific community. The DHCR working group aims
                        to create a link between research, academic teaching and the student community.
                    </p>
                    <p>
                        Both CLARIN and DARIAH are a European Research Infrastructure Consortium (ERIC),
                        a legal entity for infrastructures on a non-economic basis. The DHCR will be
                        further developed and maintained as a collaboration of the two ERICs.
                    </p>
                </div>
            </div>
            
        </div>
        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <?= $this->Html->script('jquery-3.4.1.min.js') ?>
        <?= $this->Html->script('accordeon') ?>
    </body>
</html>

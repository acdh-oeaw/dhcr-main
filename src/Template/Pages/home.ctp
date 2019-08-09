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
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Digital Humanities Course Registry API
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<header class="row">
    <div class="header-image">
        <h1>DHCR-API</h1>
    </div>
    <div class="header-title">
        <h1>The Digital Humanities Course Registry API</h1>
    </div>
</header>



<div class="row">
    <div class="columns large-6">
        <h4>About the DH Course Registry</h4>
        <p>
            The Digital Humanities Course Registry (DHCR) collects metadata on academic education programmes,
            trainings and courses about methods,
            tools and topics in the field of the digital humanities.
            The overall API output format is JSON.
        </p>
        <p>Visit the Digital Humanities Course Registry home page for more information!</p>
        <p>
            <a href="https://registries.clarin-dariah.eu/courses" target="_blank">DHCR Home Page</a>
        </p>
    </div>
    
    <div class="columns large-6">
        <h4>Documentation</h4>
        <p>
            <a href="https://app.swaggerhub.com/apis-docs/hashmich/DHCR-API/1.0" target="_blank">
                API docs on Swagger
            </a>
        </p>
        
        <h4>Error Reports &amp; Feature Requests</h4>
        <p>
            <a href="https://github.com/hashmich/DHCR-API/issues" target="_blank">
                Issue tracker on GitHub
            </a>
        </p>
        
        <h4>Legal Information</h4>
        <p>
            <a href="https://shared.acdh.oeaw.ac.at/acdh-common-assets/api/imprint.php?serviceID=7435" target="_blank">
                Imprint
            </a>
        </p>
        <p>
            All course meta data is licensed using
            <a href="https://creativecommons.org/licenses/by/4.0/" target="_blank">CC-BY 4.0</a>
        </p>
    </div>
    <hr />
</div>

<div class="row">
    <div class="columns large-6">
        <h4>Getting Started</h4>
        <dl>
            <dt>List of all courses, including historical records</dt>
            <dd>
                <?php echo $this->Html->link(Router::url('/courses/index', true), '/courses/index'); ?>
            </dd>
            <dt>List of recent, maintained courses (as listed on home page)</dt>
            <dd>
                <?php echo $this->Html->link(Router::url('/courses/index?recent', true), '/courses/index?recent'); ?>
            </dd>
            <dt>Use of filter parameters</dt>
            <dd>
                For a commplete parameter reference, please check the <a href="https://app.swaggerhub.com/apis-docs/hashmich/DHCR-API/1.0" target="_blank">
                    API docs
                </a>.<br />
                <?php echo $this->Html->link(Router::url('/courses/index?country_id=3', true), '/courses/index?country_id=3'); ?>
            </dd>
            <dt>Count results</dt>
            <dd>
                The count method accepts the same arguments as /courses/index. <br />
                <?php echo $this->Html->link(Router::url('/courses/count?recent', true), '/courses/count?recent'); ?>
            </dd>
        </dl>
    </div>
    <div class="columns large-6">
        <dl>
            <dt>List of all countries</dt>
            <dd>
                <?php echo $this->Html->link(Router::url('/countries/index', true), '/countries/index'); ?>
            </dd>
            <dt>List of institutions</dt>
            <dd>
                <?php echo $this->Html->link(Router::url('/institutions/index', true), '/institutions/index'); ?>
            </dd>
            <dt>List of Disciplines</dt>
            <dd>
                <?php echo $this->Html->link(Router::url('/disciplines/index', true), '/disciplines/index'); ?>
            </dd>
            <dt>Get a course count on institutions, sorted by course count</dt>
            <dd>
                <?php echo $this->Html->link(Router::url('/institutions/index?sort_count', true), '/institutions/index?sort_count'); ?><br />
                Grouped by country:<br />
                <?php echo $this->Html->link(Router::url('institutions/index?sort_count&group', true), '/institutions/index?sort_count&group'); ?>
            </dd>
        </dl>
    
    </div>
    <hr />
</div>


</body>
</html>

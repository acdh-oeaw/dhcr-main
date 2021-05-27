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
    <?= $this->Html->css('users.css') ?>
    <?= $this->Html->css('/leaflet/leaflet.css') ?>
</head>

<body class="users <?= $this->request->getParam('action') ?>">
<div class="wrapper">
    <div id="header">
        <div id="logo">
            <?= $this->Html->link('<span class="glyphicon glyphicon-home"></span>Back', '/', [
                'class' => 'blue users home button','escape' => false]); ?>
            <?= $this->Html->image('logo-300.png', [
                'url' => '/',
                'alt' => 'Digital Humanities Course Registry (logo)'
            ]); ?>
        </div>
        <div id="menu">
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-list">Everything Else</span>',
                '/subscriptions/add', [
                'class' => 'blue button',
                'title' => 'Everything Else',
                'escape' => false
            ]) ?>
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-education">Your Courses</span>',
                '/courses/my_courses', [
                'class' => 'blue button',
                'title' => 'Your Courses',
                'escape' => false
            ]) ?>
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-user">Profile Settings</span>',
                '/users/profile', [
                'class' => 'blue button',
                'title' => 'Profile Settings',
                'escape' => false
            ]) ?>
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-flag">Dashboard</span>',
                '/users/dashboard', [
                'class' => 'blue button',
                'title' => 'Dashboard',
                'escape' => false
            ]) ?>
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-off">Logout</span>',
                '/users/logout', [
                'class' => 'button',
                'id' => 'logout-button',
                'escape' => false
            ]) ?>
        </div>
    </div>

    <?= $this->fetch('content') ?>

    <?= $this->element('default_footer') ?>

</div>

<?= $this->Flash->render('flash') ?>

<?= $this->Html->script('jquery-3.4.1.min.js') ?>

<?= $this->Html->script('/leaflet/leaflet') ?>
<?= $this->Html->script('/leaflet/leaflet.markercluster') ?>

<?= $this->Html->script(['sharing','map','modal',
    'filter','filter_helper']) ?>

<?= $this->element('matomo') ?>

</body>
</html>

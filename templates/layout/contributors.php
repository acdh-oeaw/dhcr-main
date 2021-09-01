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

    <?= $this->Html->css('contributors.css') ?>

    <?= $this->Html->meta('icon') ?>
</head>

<?php
$bodyClasses = (!empty($bodyClasses))
    ? 'users '.$this->request->getParam('action').' '.$bodyClasses
    : 'users '.$this->request->getParam('action'); ?>
<body class="<?= $bodyClasses ?>">
<div class="wrapper">
    <div id="page-head">
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
                '<span class="glyphicon glyphicon-menu-hamburger">Menu</span>',
                '/pages/dashboard-sitemap', [
                'class' => 'button',
                'id' => 'menu-button',
                'escape' => false,
                'title' => 'Menu'
            ]) ?>
        </div>

    </div>

    <div id="content">
        <?= $this->fetch('content') ?>
    </div>

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

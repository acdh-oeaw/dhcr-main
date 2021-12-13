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
    ? 'users ' . $this->request->getParam('action') . ' ' . $bodyClasses
    : 'users ' . $this->request->getParam('action'); ?>

<body class="<?= $bodyClasses ?>">
    <div class="wrapper">
        <div id="page-head">
            <div id="logo">
                <?= $this->Html->link('<span class="glyphicon glyphicon-home"></span>Back', '/', [
                    'class' => 'blue users home button', 'escape' => false
                ]); ?>
                <?= $this->Html->image('logo-300.png', [
                    'url' => '/',
                    'alt' => 'Digital Humanities Course Registry (logo)'
                ]); ?>
            </div>
            <div id="menu">
                <?= $this->Html->link(
                    '<span class="glyphicon glyphicon-menu-hamburger">Menu</span>',
                    '/pages/contributor-sitemap',
                    [
                        'class' => 'button',
                        'id' => 'menu-button',
                        'escape' => false,
                        'title' => 'Menu'
                    ]
                ) ?>
            </div>
            <?= $this->element('contributor-sitemap') ?>
        </div>

        <div id="breadcrums">
            <p></p>
            <?php
            // Home
            echo $this->Html->link(__('Home'), ['controller' => 'Courses', 'action' => 'index'], ['class' => 'side-nav-item']);
            echo ' / ';
            // First depth
            echo $this->Html->link(__('Dashboard'), ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'side-nav-item']);
            // Second depth
            echo (isset($title)) ? ' / ' . $title : '';
            ?>
        </div>

        <div id="welcome_user">
            <?php
            echo '<p></p>';
            // Welcome user
            echo 'Hello ' . ucfirst(trim($user->academic_title)) . ' ' . ucfirst(trim($user->first_name)) . ' ' . ucfirst(trim($user->last_name))
                . ', thanks for contributing to the DHCR as <strong><font color="black"> ';
            switch ($user->user_role_id) {
                case 1:
                    echo 'administrator.';
                    break;
                case 2:
                    echo 'moderator</font></strong> of  <strong><font color="black">' . $user->country->name . '.';
                    break;
                case 3:
                    echo 'contributor.';
                    break;
            }
            echo '</font></strong>';
            ?>
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

    <?= $this->Html->script(['modal', 'sitemap', 'accordeon']) ?>

    <script type="application/javascript">
        var sitemap;
        $(document).ready(function() {
            if ($('.flash-message').length) {
                $('.flash-message').slideDown('fast').delay(8000).fadeOut('slow');
            }
            sitemap = new Sitemap();
            $(document).on('click', '#menu-button', function(e) {
                sitemap.show(e);
            });
        });
    </script>

    <?= $this->fetch('script') ?>
    <?= $this->element('matomo') ?>

</body>

</html>
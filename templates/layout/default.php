<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Element('meta') ?>
    <?= $this->Html->css('default.css') ?>
    <?= $this->fetch('css') ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
</head>
<?php $bodyClasses = (!empty($bodyClasses)) ? ' class="' . $bodyClasses . '"' : ''; ?>
<body<?= $bodyClasses ?>>
    <div class="wrapper">
        <div id="page-head">
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-home"></span><span>Home</span>',
                '/',
                [
                    'class' => 'blue menu icon button',
                    'id' => 'back-button',
                    'escape' => false
                ]
            ); ?>
            <?= $this->Html->link(
                '<span class="glyphicon glyphicon-menu-hamburger"></span><span>Menu</span>',
                '/pages/sitemap',
                [
                    'class' => 'menu icon button',
                    'id' => 'menu-button',
                    'escape' => false,
                    'title' => 'Menu'
                ]
            ) ?>
            <?= $this->element('sitemap') ?>
            <h1>
                Digital Humanities Course Registry
                <?= $this->Html->image('logo-500.png', [
                    'alt' => 'logo',
                    'width' => 500,
                    'height' => 114,
                    'url' => '/'
                ]) ?>
            </h1>
        </div>
        <div id="content">
            <?= $this->fetch('content') ?>
        </div>
        <?= $this->element('default_footer') ?>
    </div>
    <?= $this->Flash->render('flash') ?>
    <?= $this->Html->script('jquery-3.4.1.min.js') ?>
    <?= $this->Html->script(['modal', 'sitemap']) ?>
    <script type="application/javascript">
        var BASE_URL = '<?= Router::url('/', true) ?>';
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

        function recaptchaCallback(token) {
            $(".captcha-form").first().submit();
        }
    </script>
    <?php
    echo $this->fetch('script');
    echo $this->element('matomo');
    if (!Configure::read('debug'))
        echo $this->Html->script('https://www.google.com/recaptcha/api.js');
    ?>
    </body>

</html>
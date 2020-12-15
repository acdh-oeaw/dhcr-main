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

    <?= $this->Html->css('static_page.css') ?>
    <?= $this->Html->meta('icon') ?>
</head>
<body>
<div class="wrapper">
    <?= $this->Html->link('Back to Start', '/', ['class' => 'blue back button']); ?>
    <div id="page-head">
        <h1>
            Digital Humanities Course Registry
            <?= $this->Html->image('logo-500.png', [
                'alt' => 'logo',
                'width' => 500,
                'height' => 114,
                'url' => '/']) ?>
        </h1>

        <?= $this->fetch('title') ?>
    </div>

    <?= $this->fetch('content') ?>

    <div id="footer" class="footer">
        <p class="imprint"><?= $this->Html->link('Imprint',
                '/pages/info/#imprint') ?></p>
        <p class="license"><?= $this->Html->link('CC-BY 4.0',
                'https://creativecommons.org/licenses/by/4.0/',
                ['target' => '_blank']) ?></p>
        <p class="copyright">&copy;2014-<?= date('Y') ?></p>
    </div>

</div>
<?= $this->Flash->render('flash') ?>

<?= $this->Html->script('jquery-3.4.1.min.js') ?>
<?= $this->Html->script(['accordeon','hash']) ?>

<script type="application/javascript">
    $(document).ready( function() {

        if($('.flash-message').length) {
            $('.flash-message').slideDown('fast').delay(8000).fadeOut('slow');
        }
    });

    function recaptchaCallback(token) {
        $(".captcha-form").first().submit();
    }
</script>

<script src="https://www.google.com/recaptcha/api.js" type="application/javascript"></script>
<?= $this->element('matomo') ?>
<?= $this->fetch('script') ?>
</body>
</html>

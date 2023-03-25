<?php

use Cake\Core\Configure;

?>
<div class="statistics content">
    <p></p>
    <h2><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;&nbsp;App Info</h2>
    <h3>DHCR Application Version</h3>
    <p><?php include('../VERSION.txt'); ?></p>
    <h3>PHP Version</h3>
    <p><?= phpversion() ?></p>
    <h3>CakePHP Framework Version</h3>
    <p><?= Configure::version() ?></p>
    <h3>Debug Mode</h3>
    <p>
        <?php
        if (Configure::read('debug') == true) {
            echo 'DEBUG ON';
        } else {
            echo 'DEBUG OFF';
        }
        ?>
    </p>
</div>
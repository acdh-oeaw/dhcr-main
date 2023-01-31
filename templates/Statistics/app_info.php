<div class="statistics content">
    <p></p>
    <h2><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;&nbsp;App Info</h2>
    <h3>DHCR Application Version</h3>
    <p><?php include('../VERSION.txt'); ?></p>
    <h3>PHP Version</h3>
    <p><?= phpversion() ?></p>
    <h3>Debug Mode</h3>
    <p>
        <?php
        if (env('debug')) {
            echo 'DEBUG ON';
        } else {
            echo 'DEBUG OFF';
        }
        ?>
    </p>
</div>
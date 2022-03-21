<?php
use Cake\Core\Configure;
echo "\n";
echo Configure::read('dhcr.baseUrl').'users/reset_password/'.$user->password_token;
echo "\n";
?>
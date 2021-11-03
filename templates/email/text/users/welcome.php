<?php
use Cake\Core\Configure;

echo "Dear $user->first_name $user->last_name, \n";
echo "your DHCR account has just been approved!\n\n";

echo "Please follow this link to log in and start adding courses:\n";
echo Configure::read('dhcr.baseUrl').'users/sign-in';
echo "\n";
?>

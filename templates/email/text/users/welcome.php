<?php

use Cake\Core\Configure;

echo "Dear $user->first_name $user->last_name, \n";
echo "your DHCR account has been enabled!\n\n";
echo "Follow this link to log in:\n";
echo Configure::read('dhcr.baseUrl') . 'users/sign-in';
echo "\n";

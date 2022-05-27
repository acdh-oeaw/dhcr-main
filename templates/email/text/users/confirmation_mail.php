<?php

use Cake\Core\Configure;

echo "To verify your email address, click the link below.\n";
echo "\n";
echo Configure::read("dhcr.baseUrl") . 'users/verify_mail/' . $user->email_token;

<?php

use Cake\Core\Configure;

echo "To change your password, click the link below.\n";
echo "If you did not request the password reset, you can ignore this email.\n";
echo "(Valid 1 hour until " . $user->password_token_expires->i18nFormat('HH:mm:ss') . "):\n";
echo "\n";
echo Configure::read('dhcr.baseUrl') . 'users/reset_password/' . $user->password_token;
echo "\n";

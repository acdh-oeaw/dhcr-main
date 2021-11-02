<?php
use Cake\Routing\Router;

echo "To change your password, click the link below.\n";
echo "If you did not request the password reset, you can ignore this email.\n";
echo "\n";
echo Router::url('/users/reset_password/'.$user->password_token, true);
echo "\n";
?>

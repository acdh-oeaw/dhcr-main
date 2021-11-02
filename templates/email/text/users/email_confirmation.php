<?php
use Cake\Routing\Router;
echo "To verify your email address, click the link below.\n";
echo "\n";
echo Router::url('/users/confirm_mail/'.$user->email_token, true);
?>

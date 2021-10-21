<?php
echo "To verify your email address, click the link below.\n";
echo "\n";
echo Router::url([
	'controller' => 'users',
	'action' => 'confirm_mail',
	$user->email_token
], true);
?>

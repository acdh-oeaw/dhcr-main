<?php
echo "Dear $user->first_name, \n";
echo "your DHCR account has just been approved!\n\n";

echo "Please follow this link to log in and start adding courses:\n";
echo Router::url('/users/sign-in', true);
echo "\n";
?>

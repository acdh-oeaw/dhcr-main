<?php

use Cake\Core\Configure;
?>
Hello Admin,

a new user has registered at the DHCR and is waiting for approval of the new account!
In first place, you should now check the user's eligibility.

<?php if (empty($user->institution_id)) : ?>
    The user could not find their organisation on the list and therefore indicated the following to be added:
    `<?= $user->university ?>`

    Please add the city record first, if it does not exist.
    Then create the institution record (institution depends on country and city).
<?php endif; ?>

User Overview
• Name: <?= trim($user->academic_title . ' ' . $user->first_name . ' ' . $user->last_name) ?>

• Email: <?= $user->email ?>

• About: <?= $user->about ?>

<?php
if ($user->institution != NULL) {
    echo "• Affiliation:  " . $user->institution->name . "\n\n";
}
?>

Click here to start the approval process,
(valid 7 days until <?= $user->approval_token_expires->i18nFormat('yyyy-MM-dd'); ?>):
<?= Configure::read('dhcr.baseUrl') . 'users/approve/' . $user->approval_token ?>
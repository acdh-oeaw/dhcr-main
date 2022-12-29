<?php

use Cake\Core\Configure;
?>
Dear Subscriber,

please click the link below to complete your Course Alert:
<?php echo Configure::read("dhcr.baseUrl") . "subscriptions/edit/" . $subscription->confirmation_key; ?>
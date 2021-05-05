<?php
use Cake\Core\Configure;
?>
Dear Subscriber,

please click the link below to complete your subscription:
<?php echo Configure::read("dhcr.baseUrl")."subscriptions/edit/".$subscription->confirmation_key; ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */

use Cake\Core\Configure;
?>

<?php $this->start('title'); ?>
<div class="title">
    <p>Subscribe to new courses.</p>
    <p>
        After confirmation of your e-mail address,
        you can set filters to stay informed about courses in
        disciplines, languages or countries you are interested in.
    </p>
</div>
<?php $this->end(); ?>



<div class="subscriptions form">
    <?= $this->Form->create($subscription, [
        'novalidate' => false,
        'class' => 'captcha-form'
    ]) ?>
    <?php
    echo $this->Form->control('email');
    echo $this->Form->control('country_id', ['title' => 'Optional. Let us know where you are coming from.']);
    ?>
    <?= $this->Form->submit('Submit', array(
        'class' => 'g-recaptcha small blue button right',
        'data-sitekey' => Configure::read('reCaptchaPublicKey'),
        'data-callback' => 'recaptchaCallback'
    )) ?>
    <?= $this->Form->end() ?>
</div>

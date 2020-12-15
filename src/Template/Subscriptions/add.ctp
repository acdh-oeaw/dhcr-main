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
    <p>
        In case you already did subscribe,
        you can request the confirmation mail
        here again to edit your existing subscription.
    </p>
</div>
<?php $this->end(); ?>



<div class="subscriptions-form optionals">
    <?= $this->Form->create($subscription, [
        'novalidate' => false,
        'class' => 'captcha-form'
    ]) ?>

    <fieldset class="invisible">
        <?php
        echo $this->Form->control('email');
        echo $this->Form->control('country_id', [
            'empty' => '- Where are you from? (optional) -']);
        echo $this->Form->control('privacy_declaration', [
            'type' => 'textarea',
            'label' => 'Consent',
            'readonly' => true,
            'rows' => 3,
            'value' => 'By subscribing for new courses on the Digital Humanities Course Registry,
you agree to processing of your personal data for the purposes of this service.
Your personal data is stored and processed by the ACDH,
but not made public or shared with third parties.'
        ]);
        echo $this->Form->control('consent', [
            'type' => 'checkbox',
            'label' => ['style' => 'grid-area: input', 'text' => 'I agree']]);
        ?>
    </fieldset>


    <?= $this->Form->submit('Submit', array(
        'class' => 'g-recaptcha small blue button right',
        'data-sitekey' => Configure::read('reCaptchaPublicKey'),
        'data-callback' => 'recaptchaCallback'
    )) ?>
    <?= $this->Form->end() ?>
</div>

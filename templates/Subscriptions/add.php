<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */

use Cake\Core\Configure;
?>

<?php $this->start('page_head'); ?>
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
        ?>
        <div class="input paragraph">
            <label for="privacy-declaration">Consent</label>
            <p name="privacy_declaration" id="privacy-declaration">
                For this service, your personal data is stored and processed
                by the Austrian Academy of Sciences, but not made public or
                shared with third parties.
            </p>
        </div>
        <?php
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

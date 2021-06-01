<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */

use Cake\Core\Configure;
?>

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

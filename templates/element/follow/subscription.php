<?php

use Cake\Core\Configure;
?>
<div class="subscriptions-form optionals headspace">
    <?= $this->Form->create($subscription, [
        'novalidate' => false,
        'class' => 'captcha-form',
        'url' => ['controller' => 'subscriptions', 'action' => 'add']
    ]) ?>
    <?php   // todo everything in 1 php tag
    echo $this->Form->control('email');
    echo $this->Form->control('country_id', [
        'empty' => '- Where are you from? (optional) -'
    ]);
    ?>
    <?php
    $classes = ['input', 'info', 'required'];
    if ($this->Form->isFieldError('consent')) $classes[] = 'error';
    ?>
    <div class="<?= implode(' ', $classes) ?>">
        <label for="privacy-declaration">Terms</label>
        <div name="privacy_declaration" id="privacy-declaration">
            For this service, your personal data is stored and processed
            by the Austrian Academy of Sciences, but not made public or
            shared with third parties.
        </div>
        <?= $this->Form->control('consent', [
            'type' => 'checkbox',
            'label' => 'I agree',
            'required' => false,
            'error' => false
        ]) ?>
        <?= ($this->Form->isFieldError('consent')) ? $this->Form->error('consent') : '' ?>
    </div>
    <?= $this->Form->submit('Submit', array(
        'class' => 'g-recaptcha small blue button right',
        'data-sitekey' => Configure::read('reCaptchaPublicKey'),
        'data-callback' => 'recaptchaCallback'
    )) ?>
    <?= $this->Form->end() ?>
</div>
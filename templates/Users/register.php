<?php

use Cake\Core\Configure;

$this->Html->css('https://use.fontawesome.com/releases/v5.8.2/css/all.css', ['block' => true]);
$this->set('bodyClasses', 'registration');
$this->Html->scriptStart(['block' => true]); ?>
$('#togglePassword').hover(function (e) {
$('#password').attr('type', 'text');
},function (e) {
$('#password').attr('type', 'password');
})
<?php $this->Html->scriptEnd(); ?>
<h2>User Registration</h2>
<p>
    Lecturers, programme directors and/or national moderators who want to add or curate course metadata to the registry are invited to
    open a DHCR account by filling in this registration form.
</p>
<?php if (!$user->hasErrors(false)) : ?>
    <p class="notice">
        All other users can use the registry, without registration. See this <a href="https://www.youtube.com/embed/s-YsnpKCaUE">
            tutorial video</a> to learn how to browse or filter the courses.
    </p>
<?php endif; ?>
<div class="optionals headspace">
    <?php
    echo $this->Form->create($user, ['id' => 'registration_form']);
    echo $this->Form->control('academic_title');
    echo $this->Form->control('first_name');
    echo $this->Form->control('last_name');
    echo $this->Form->control('about', [
        'type' => 'textarea',
        'label' => ['text' => 'Your Position', 'class' => 'depending'],
        'placeholder' => 'Please provide some verifiable details about your position (e.g. lecturer, assistant, professor), so that our moderators can judge about your eligibility to contribute content to the DHCR.',
    ]);
    echo $this->Form->control('institution_id', [
        'label' => ['text' => 'Affiliation', 'class' => 'depending'],
        'empty' => '- pick your affiliation -',
        'required' => false
    ]);
    echo $this->Form->control('university', [
        'label' => ['text' => 'Other Organisation'],
        'type' => 'textarea',
        'placeholder' => 'If you cannot find your affiliation in the dropdown list above, we need the country, city and name of your organisation provided here instead.'
    ]);
    echo $this->Form->control('email', ['placeholder' => 'Preferably, use your institutional address']);
    $this->Form->setTemplates([
        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>
        <i class="far fa-eye" id="togglePassword">reveal password</i>'
    ]);
    echo $this->Form->control('password');
    $this->Form->setTemplates(['input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>']);
    $classes = ['input', 'info', 'required'];
    if ($this->Form->isFieldError('consent')) $classes[] = 'error';
    ?>
    <div class="<?= implode(' ', $classes) ?>">
        <label for="terms-info">Privacy Conditions</label>
        <div class="info" id="terms-info">
            <?= $this->Html->link('View', '/users/which_terms?', ['id' => 'which_terms']) ?>
            <div style="display:none" id="terms_content"><?= $this->element('users/which_terms') ?></div>
        </div>
        <?= $this->Form->control('consent', [
            'type' => 'checkbox',
            'value' => 1,
            'label' => 'I agree',
            'required' => false,
            'error' => false
        ]) ?>
        <?= ($this->Form->isFieldError('consent')) ? $this->Form->error('consent') : '' ?>
    </div>
    <div class="input info">
        <label for="newsletter-info">Contributor Mailing List</label>
        <div class="info" id="newsletter-info">
            If you contribute courses to the DHRC, it is recommended to sign up for our Contributor Mailing List to stay informed about recent
            technical developments, staff updates and much more.
        </div>
        <?= $this->Form->control('mail_list', [
            'value' => 1,
            'label' => 'Yes, subscribe to the Contributor Mailing List!',
            'required' => false,
            'type' => 'checkbox'
        ]) ?>
    </div>
    <?= $this->Form->button(__('Register'), [
        'class' => 'right g-recaptcha',
        'data-sitekey' => Configure::read('reCaptchaPublicKey'),
        'data-callback' => 'recaptchaCallback'
    ]) ?>
    <?= $this->Form->end() ?>
</div>
<?php
$this->Html->scriptStart(['block' => true]);
?>
function recaptchaCallback(token) {
document.getElementById("registration_form").submit();
}
$(document).ready( function() {
$('#which_terms').click(function(event) {
event.preventDefault()
let modal = new Modal('Privacy Conditions for DHCR Contributors')
modal.add($('#terms_content').contents().clone())
modal.create()
})
})
<?php $this->Html->scriptEnd(); ?>
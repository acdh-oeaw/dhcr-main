<?php
$this->set('bodyClasses', 'registration');
?>
<h2>Account completion</h2>
<p>
    To start contributing to the DHCR, please complete your account data.
    If you do not find your organisation in the available options in the form,
    please provide all required information in the field "Other Organisation" below.
    An admin or moderator action is required in that case, to extend our taxonomy data and
    enable your account.
</p>
<p>
    Once your account is completed and enabled, you can login using your institutional identity provider.
    At any time you can choose using classic login by setting a password via the password reset button,
    underneath the classic login form.
</p>
<?php if (!$user->hasErrors(false)) : ?>
    <p class="notice">
        You only need to register an account with the DHRC, if you are a lecturer or other academic institution member
        and want to add or curate course meta data.
        All other audience may use the publicly available content and functionality freely.
        See this <a href="https://www.youtube.com/embed/s-YsnpKCaUE">tutorial video</a> for advice
        on how to browse or filter our listed courses.
    </p>
<?php endif; ?>
<div class="optionals headspace">
    <?= $this->Form->create($user, ['id' => 'registration_form']) ?>
    <?= $this->Form->control('email', ['placeholder' => 'Preferably, use your institutional address']) ?>
    <?= $this->Form->control('institution_id', [
        'label' => ['text' => 'Affiliation', 'class' => 'depending'],
        'empty' => '- pick your affiliation -',
        'required' => false
    ]) ?>
    <?= $this->Form->control('university', [
        'label' => ['text' => 'Other Organisation', 'class' => 'depending'],
        'type' => 'textarea',
        'placeholder' => 'If you cannot find your affiliation in the dropdown list above,
we need the country, city and name of your organisation provided here instead.'
    ]) ?>
    <?= $this->Form->control('academic_title') ?>
    <?= $this->Form->control('first_name') ?>
    <?= $this->Form->control('last_name') ?>
    <?php
    $classes = ['input', 'info', 'required'];
    if ($this->Form->isFieldError('consent')) $classes[] = 'error';
    ?>
    <div class="<?= implode(' ', $classes) ?>">
        <label for="terms-info">Terms</label>
        <div class="info" id="terms-info">
            <?= $this->Html->link('Which terms?', '/users/which_terms?', ['id' => 'which_terms']) ?>
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
        <label for="newsletter-info">Newsletter</label>
        <div class="info" id="newsletter-info">
            By signing into our contributor newsletter, we can reach out to you about
            technical updates or news concerning the DHCR platform, team or network.
        </div>
        <?= $this->Form->control('mail_list', [
            'value' => 1,
            'label' => 'Yes, subscribe me!',
            'required' => false,
            'type' => 'checkbox'
        ]) ?>
    </div>
    <?= $this->Form->button(__('Register')) ?>
    <?= $this->Form->end() ?>
</div>
<?php $this->Html->scriptStart(['block' => true]); ?>
$(document).ready( function() {
$('#which_terms').click(function(event) {
event.preventDefault()
let modal = new Modal('Privacy Conditions for DHCR Contributors')
modal.add($('#terms_content').contents().clone())
modal.create()
})
})
<?php $this->Html->scriptEnd(); ?>
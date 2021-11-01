<?php
use Cake\Core\Configure;

$this->set('bodyClasses', 'registration');
?>

<h2>User Registration</h2>

<p>
    Open an account as a lecturer, programme director or national moderator.<br>
    After registration, you will be able to add your courses to the registry.
</p>
<?php if(!$user->hasErrors(false)) : ?>
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
    <?= $this->Form->control('password') ?>

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

    <?= $this->Form->control('about', [
        'type' => 'textarea',
        'label' => 'Your Position',
        'placeholder' => 'Please provide some verifiable details about your position (e.g. lecturer, assistant, professor),
so that our moderators can judge about your eligibility to contribute content to the DHCR.',
    ]) ?>

    <?php
    $classes = ['input','info','required'];
    if($this->Form->isFieldError('consent')) $classes[] = 'error';
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



    <?= $this->Form->button(__('Register'), [
        'class' => 'right g-recaptcha',
        'data-sitekey' => Configure::read('reCaptchaPublicKey'),
        'data-callback' => 'recaptchaCallback']) ?>
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

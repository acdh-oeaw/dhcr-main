<?php
$this->Html->css('https://use.fontawesome.com/releases/v5.8.2/css/all.css', ['block' => true]);
$this->set('bodyClasses', 'registration');
$this->Html->scriptStart(['block' => true]); ?>
$('#togglePassword').hover(function (e) {
$('#password').attr('type', 'text');
},function (e) {
$('#password').attr('type', 'password');
})
<?php $this->Html->scriptEnd(); ?>
<h2>Reset your password</h2>
<?php if (!empty($mailSent)) : ?>
    <p>
        Please check your email inbox to complete the password reset.<br>
        (You can close this window)
    </p>
<?php else : ?>
    <?php if (empty($token)) : ?>
        <p>Please enter your email address.</p>
    <?php else : ?>
        <p>Now set a new password and you are ready to log in again!</p>
    <?php endif; ?>
    <div class="headspace">
        <?= $this->Form->create() ?>
        <?php
        if (empty($token)) {
            echo $this->Form->control('email');
        } else {
            $this->Form->setTemplates([
                'inputContainer' => '<div class="input {{type}}{{required}}">
                    {{content}} <i class="far fa-eye" id="togglePassword">reveal password</i></div>'
            ]);
            echo $this->Form->control('password');
        }
        ?>
        <?= $this->Form->button(__('Continue'), ['class' => 'right']) ?>
        <?= $this->Form->end() ?>
    </div>
<?php endif; ?>
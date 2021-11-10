<?php
$this->set('bodyClasses', 'registration');
?>

<h2>Reset your password</h2>

<?php if(!empty($mailSent)): ?>
<p>
    Please check your email inbox to complete the password reset.<br>
    (You can close this window)
</p>
<?php else: ?>
    <?php if(empty($token)): ?>
    <p>
        Please enter your email address.
    </p>
    <?php else: ?>
    <p>
        Now set a new password and you are ready to log in again!
    </p>
    <?php endif; ?>

    <div class="headspace">
        <?= $this->Form->create() ?>
        <?php
        if(empty($token)) echo $this->Form->control('email');
        else echo $this->Form->control('password');
        ?>
        <?= $this->Form->button(__('Continue'), ['class' => 'right']) ?>
        <?= $this->Form->end() ?>
    </div>
<?php endif; ?>

<?php
$this->set('bodyClasses', 'registration');
?>
<h2>Connect your locally existing account</h2>
<p>
    You have logged in using your institutional identity provider.<br>
    To connect this external identity to your already existing local account,
    please provide the credentials for your DHRC account.
</p>
<?= $this->element('users/external_identity') ?>
<div class="users form">
    <?= $this->Form->create(null, ['url' => '/users/sign-in?redirect=/users/connect_identity']) ?>
    <?= $this->Form->control('email') ?>
    <?= $this->Form->control('password') ?>
    <?= $this->Form->button(__('Connect'), ['class' => 'right']); ?>
    <?= $this->Form->end() ?>
</div>
<div class="login-alternatives">
    <?= $this->Html->link('Reset Password', '/users/reset_password', ['class' => 'button small']) ?>
    <?= $this->Html->link('Go Back', '/users/unknown_identity', [
        'class' => 'blue button small'
    ]) ?>
</div>
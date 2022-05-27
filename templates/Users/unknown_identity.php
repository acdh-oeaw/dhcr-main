<?php

use Authentication\View\Helper\IdentityHelper;

$this->set('bodyClasses', 'registration');
?>
<h2>Are you new to the DHCR?</h2>
<p>You have been succesfully identified by an external identity provider,
    but that identity is not linked to a local account.</p>
<?= $this->element('users/external_identity') ?>
<?php if (!$this->Identity->isLoggedIn()) : ?>
    <p>Please decide, how to continue.</p>
    <div class="grid-columns">
        <div class="grid-item">
            <p>Have you been using the DHCR before?</p>
            <p>To access your existing courses or moderation dashboard, please click here.</p>
            <?= $this->Html->link('Existing account', '/users/connect_identity', ['class' => 'blue button']) ?>
        </div>
        <div class="grid-item">
            <p>You are new to the DHCR.</p>
            <p>Continue with the completion of your account data.</p>
            <?= $this->Html->link('New account', '/users/register_identity', ['class' => 'button']) ?>
        </div>
    </div>
<?php elseif (!$this->Identity->get('shib_eppen')) : ?>
    <p>Connect this external identity to your local account.</p>
    <div class="grid-columns">
        <div class="grid-item">
            <?= $this->Html->link('Ignore', '/users/ignore_identity', ['class' => 'button']) ?>
        </div>
        <div class="grid-item">
            <?= $this->Html->link('Connect', '/users/connect_identity', ['class' => 'blue button']) ?>
        </div>
    </div>
<?php elseif ($this->Identity->get('shib_eppen') !== $identity['shib_eppen']) : ?>
    <p>You have a valid external identity, that does not match the identity this account is currently connected to.<br>
        If you decide to connect to that identity, you can only access the DHCR dashboard using the new identity.</p>
    <div class="grid-columns">
        <div class="grid-item">
            <?= $this->Html->link('Ignore', '/users/ignore_identity', ['class' => 'button']) ?>
        </div>
        <div class="grid-item">
            <?= $this->Html->link('Connect New Identity', '/users/connect_identity', ['class' => 'blue button']) ?>
        </div>
    </div>
<?php endif; ?>
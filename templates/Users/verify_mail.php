<?php
$this->set('bodyClasses', 'registration');
?>
<h2>Email Address Verification</h2>
<p>To change your email address, we need to verify you have access to the provided address.
    Please submit the form below to start the process.</p>
<div class="headspace">
    <?= $this->Form->create() ?>
    <?= $this->Form->control('new_email', ['placeholder' => 'Preferably, use your institutional address']) ?>
    <?= $this->Form->button(__('Verify mail'), ['class' => 'right']) ?>
    <?= $this->Form->end() ?>
</div>
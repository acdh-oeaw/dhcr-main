<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;&nbsp;Change Email Address</h2>
    <div class="column-responsive column-80">
        <b>Current Email Address: <p><i><?= $user->email ?></i></b>
        <p></p>
        <p>
            To change your email address, first fill in the form below so that we can verify it.
            <br>Please submit the form below to start the process.
        </p>
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Change Email Address') ?></legend>
                <?php
                echo $this->Form->control('new_email', ['label' => 'New Email Address*', 'placeholder' => 'Preferably, use your institutional address']);
                echo $this->Form->control('password', ['label' => 'Current Password*']);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Verify Email Address')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
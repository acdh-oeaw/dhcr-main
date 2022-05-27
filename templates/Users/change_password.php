<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;&nbsp;Change Password</h2>
    <div class="column-responsive column-80">
        <p></p>
        <div class="users form content">
            <?= $this->Form->create() ?>
            Click the button below to receive an email with a link to change your password.
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Request password change email')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
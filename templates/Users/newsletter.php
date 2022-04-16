<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Sign up to the Mailing List</h2>
    <p></p>
    <p>As a lecturer, national moderator or programme director, you may want to sign up to our Contributor Mailing List.
        It addresses everybody involved in the contribution of course metadata for the DHCR.</p>
    <p>Stay informed about recent developments regarding the team or new technical features of the DHCR.</p>
    <p>Check the box below to subscribe, or uncheck to unsubscribe.</p>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Preferences') ?></legend>
                <?php
                echo $this->Form->control('mail_list', ['label' => 'Contributor Mailing List subscription']);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Sign up to the Mailing List</h2>
    <p></p>
    <p>National moderators, lecturers or programme directors who add or curate course metadata are invited to join 
        our contributor mailing list to stay informed about the latest developments.</p>
    <p>Check or uncheck the box below to update your subscription preferences.</p>
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
            <?= $this->Form->button(__('Update your choice')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
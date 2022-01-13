<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;Newsletter</h2>
    <p></p>
    Placeholder for a description of our newsletter, which informs the user about this communication channel.
    <p>&nbsp;</p>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Preferences') ?></legend>
                <?php
                echo $this->Form->control('mail_list', ['label' => 'Newsletter subscription']);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;Newsletter Preferences</h2>
    <p></p>
    This is a description of our newsletter, which motivates the user to subscribe.
    <p>&nbsp;</p>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Subscription preferences') ?></legend>
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
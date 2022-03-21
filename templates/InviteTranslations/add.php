<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Add Invite Translation</h2>
    <div class="column-responsive column-80">
        <div class="inviteTranslations form content">
            <?= $this->Form->create($inviteTranslation) ?>
            <fieldset>
                <legend><?= __('Add Invite Translation') ?></legend>
                <?php
                    echo $this->Form->control('name', ['label' => 'Translation Name / Language']);
                    echo $this->Form->control('subject');
                    echo '<p>Note: The text <strong><i>-fullname-</i></strong> in the message is required and will be 
                        automatically replaced by the academic title, first name and last name of the person who is sending the invitation. 
                        Please do not change or translate it. Take a look at the English translation as an example of how to use it.</p>';
                    echo $this->Form->control('messageBody', ['label' => 'Message']);
                    echo $this->Form->control('active');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
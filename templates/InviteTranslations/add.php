<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Add Translation</h2>
    <div class="column-responsive column-80">
        <div class="inviteTranslations form content">
            <?= $this->Form->create($inviteTranslation) ?>
            <fieldset>
                <legend><?= __('Add Translation') ?></legend>
                <?php
                echo $this->Form->control('language_id', ['empty' => true]);
                echo $this->Form->control('subject');
                echo '<p>The following words are required in the message:<br>
                        <strong><i><u>-fullname-</u></i></strong><br>
                        This will be automatically replaced by the academic title, first name and last name of the person who is sending the invitation.<br>
                        <strong><i><u>-passwordlink-</u></i></strong><br>
                        This will be automatically replaced by a link where the user can set his password. This link is only visible in the email.</p><p>
                        *Please do not change or translate those words.<br>
                        *Take a look at the English translation as an example of how to use it.<br>
                        *Recommended: Use the text from the message textfield on the edit page, to avoid double signatures.</p>';
                echo $this->Form->control('messageBody', ['label' => 'Message']);
                echo $this->Form->control('active', ['label' => 'Publish', 'default' => true]);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Add Translation')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
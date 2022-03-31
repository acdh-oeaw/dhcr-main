<div class="row">
<div class="column-responsive column-80">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Edit Invite Translation</h2>
        <div class="inviteTranslations form content">
            <?= $this->Form->create($inviteTranslation) ?>
            <fieldset>
                <legend><?= __('Edit Invite Translation') ?></legend>
                <?php
                    echo $this->Form->control('language_id', ['options' => $languages]);
                    echo $this->Form->control('subject');
                    echo '<p>The following words are required in the message:<br>
                        <strong><i><u>-fullname-</u></i></strong><br>
                        This will be automatically replaced by the academic title, first name and last name of the person who is sending the invitation.<br>
                        <strong><i><u>-passwordlink-</u></i></strong><br>
                        This will be automatically replaced by a link where the user can set his password. This link is only visible in the email.</p><p>
                        Please do not change or translate those words.
                        <br>Take a look at the English translation as an example of how to use it.</p>';
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
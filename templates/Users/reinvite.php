<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;&nbsp;Reinvite User</h2>
    <div class="column-responsive column-80">
        The user will receive a <i><strong><u>new</u></strong></i> email to set their password and join the DH-Courseregistry.<br>
        You will receive a BCC of this email.
        <p>&nbsp;</p>
        <div class="courses form content">
            <?= $this->Form->create($invitedUser) ?>
            <fieldset>
                <legend><?= __('Reinvite User') ?></legend>
                <p></p>
                <h3>User details</h3>
                <table>
                    <tr>
                        <td style="padding: 5px">Institution : </td>
                        <td style="padding: 5px"><?= $invitedUser->institution->name ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px">Academic Title : </td>
                        <td style="padding: 5px"><?= $invitedUser->academic_title ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px">First Name : </td>
                        <td style="padding: 5px"><?= $invitedUser->first_name ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px">Last Name : </td>
                        <td style="padding: 5px"><?= $invitedUser->last_name ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px">E-mail Address : </td>
                        <td style="padding: 5px"><?= $invitedUser->email ?></td>
                    </tr>
                </table>
                <p></p>
                <?php
                echo $this->Form->control('inviteTranslation', ['label' => 'Choose localization*', 'options' => $languageList]);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Reinvite User')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
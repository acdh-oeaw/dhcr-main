<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;Invite User</h2>
    <div class="column-responsive column-80">
        The user will recieve an email to set their password and join the DH-Courseregistry.
        <p>&nbsp;</p>
        <div class="courses form content">
            <?= $this->Form->create($invitedUser) ?>
            <fieldset>
                <legend><?= __('Invite User') ?></legend>
                <p></p>
                <h3>Step 1: Choose / Create Institution for the new user</h3>
                <p></p>Choose an institution from the list below. <br>
                If the institution is not in the list, go to 
                <?= $this->Html->link('Add Institution', ['controller' => 'institutions', 'action' => 'add']) ?> first.
                <p></p>
                <?= $this->Form->control('institution_id', ['label' => 'Institution*', 'options' => $institutions, 'empty' => true]) ?>
                <p>&nbsp;</p>
                <h3>Step 2: Enter personal details of the user</h3>
                <p></p>
                <?php
                echo $this->Form->control('academic_title');
                echo $this->Form->control('first_name', ['label' => 'First Name*']);
                echo $this->Form->control('last_name', ['label' => 'Last Name*']);
                echo $this->Form->control('email', ['label' => 'Email Address*']);
                ?>
                <p>&nbsp;</p>
                <h3>Step 3: Localize the invitation email</h3>
                <p></p>
                <b><u>Note for non-English countries</u></b><br>
                Users may respond better to an invitation in their mother language. Although the interface and the meta data in the Course 
                Registry are in English, you have the possibility to localize the invitation message.
                <p></p>
                <b>Preview localized messages</b><br>
                <?php
                foreach($inviteTranslations as $inviteTranslation) {
                    echo $this->Html->link($inviteTranslation->language->name, ['controller' => 'inviteTranslations', 
                        'action' => 'view', $inviteTranslation->id]) . '<br>';
                    }
                echo '<p></p>';
                echo $this->Form->control('inviteTranslation', ['label' => 'Choose localization*', 'options' => $languageList]);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Invite this user')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
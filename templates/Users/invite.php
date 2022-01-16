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
                <?= $this->Form->control('institution_id', ['label' => 'Institution', 'options' => ['1', '2'], 'empty' => true]) ?>
                <p>&nbsp;</p>
                <h3>Step 2: Enter personal details of the user</h3>
                <p></p>
                <?php
                echo $this->Form->control('academic_title');
                echo $this->Form->control('first_name');
                echo $this->Form->control('last_name');
                ?>
                <p>&nbsp;</p>
                <h3>Step 3: Personalize the invitation email</h3>
                <p></p>
                <?= $this->Form->control('email', ['label' => 'Email Address of the user']) ?>
                <p></p>
                <b><u>Note for non-English countries</u></b><br>
                Users may respond better to an invitation in their mother language. Although the interface and the meta data in the Course 
                Registry are in English, the fields below give you the possibility to localize or personalize the invitation message:
                <p></p>
                <?php
                $message = 
'Dear colleague,

We would like to kindly invite you to include your teaching activity into the Digital Humanities Course Registry (DHCR).

This resource offers an overview and search environment of courses related to Digital Humanities that are offered at universities and research institutes within your home country and the rest of Europe. The initiative endorses the principle that sharing knowledge is in the best interest of students, lecturers and researchers.

Our aim is twofold: 
1) we want to offer students the opportunity to identify courses of their interest at home or abroad.
2) we want to offer lecturers the possibility to get an overview of teaching activities elsewhere. 
We strongly encourage the use of the DHCR as a way for lecturers to grant access to their teaching resources to peers.

To ensure that the Course Registry grows into a sustainable resource with the widest possible coverage we need your help.

After setting your password you can enter the data about your course by clicking: Administrate Courses, Add Course.

The data that you provide will be reviewed and processed by the national coordinator who has the task of monitoring and curating the DHCR in your country. 

We sincerely hope you will contribute to our effort to expand the knowledge on how technology can support research in the humanities and social sciences.

Best wishes and thank you for your effort,

' .ucfirst($user->academic_title) . ' ' . ucfirst($user->first_name) . ' ' . ucfirst($user->last_name) . ' (moderator) and the Course Registry Team';


                echo $this->Form->control('subject', ['default' => 'Join the Digital Humanities Course Registry']);
                echo $this->Form->control('message', ['rows' => 20, 'default' => $message]);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Invite this user')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
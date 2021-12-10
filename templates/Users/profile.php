<?php
// debug($user);
// die();
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <p>&nbsp;</p>
            <h3><span class="glyphicon glyphicon-cog">&nbsp;</span><?= __('My Profile') ?></h3>
            <p>&nbsp;</p>
            <h4 class="heading"><u><?= __('Actions') ?></u></h4>
            <ul>
                <li><?= $this->Html->link(__('Change E-mail address ('.$user->email .')'), ['action' => 'changeEmail'], ['class' => 'side-nav-item']) ?></li>
                <li><?= $this->Html->link(__('Change Password'), ['action' => 'changePassword'], ['class' => 'side-nav-item']) ?></li>
                <li><?= $this->Html->link(__('Newsletter preferences'), ['action' => 'newsletterPrefs'], ['class' => 'side-nav-item']) ?></li>
                <li><?= $this->Html->link(__('Moderator preferences'), ['action' => 'moderatorPrefs'], ['class' => 'side-nav-item']) ?></li>
                </ul>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit Profile') ?></legend>
                <?php
                echo $this->Form->control('academic_title');
                echo $this->Form->control('first_name');
                echo $this->Form->control('last_name');
                echo $this->Form->control('institution_id');
                echo $this->Form->control('about');                
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?php
// debug($user);
// die();
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <p>&nbsp;</p>
            <h3><span class="glyphicon glyphicon-cog">&nbsp;</span><?= __('Moderator preferences') ?></h3>
            <p>&nbsp;</p>
            <?= $this->Html->link(__('Back to profile'), ['action' => 'profile'], ['class' => 'side-nav-item']) ?>
            <p>&nbsp;</p>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Moderator preferences') ?></legend>
                <p>
                As a moderator, you must be assigned to a country from the list.<br>
                If your country doesn't exist, please go to
                <?= $this->Html->link(__('add Country'), ['controller' => 'Countries', 'action' => 'add'], ['class' => 'side-nav-item']) ?>.</p>
                <?php
                echo $this->Form->control('user_role_id');
                echo $this->Form->control('country_id', ['label' => 'Moderated Country']);
                ?>
                
                Get notified about new account requests:
                <?php
                echo $this->Form->control('user_admin', ['label' => 'Administrate (new) users']);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?php
// debug($user);
// die();
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <p>&nbsp;</p>
            <h3><span class="glyphicon glyphicon-cog">&nbsp;</span><?= __('Change Email address') ?></h3>
            <p>&nbsp;</p>
            <?= $this->Html->link(__('Back to profile'), ['action' => 'profile'], ['class' => 'side-nav-item']) ?>
            <p>&nbsp;</p>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Change Email address') ?></legend>
                <?php
                echo $this->Form->control('new_email', ['label' => 'New Email address']);
                echo $this->Form->control('password');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
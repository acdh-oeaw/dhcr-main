<?php
// debug($user);
// die();
?>
<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;Change Email Address</h2>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Change Email Address') ?></legend>
                <?php
                echo $this->Form->control('new_email', ['label' => 'New Email Address']);
                echo $this->Form->control('password');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
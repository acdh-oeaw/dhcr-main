<?php $this->set('bodyClasses', 'login'); ?>
<?php $this->start('page_head'); ?>
<div class="title">
    <h2>User Registration</h2>
    <p>
        Open an account as a lecturer, programme director or national moderator.<br>
        After registration, you will be able to add your courses to the registry.
    </p>
</div>
<?php $this->end(); ?>

<div class="users form content">
    <?= $this->Form->create() ?>

    <?= $this->Form->control('email') ?>
    <?= $this->Form->control('password') ?>

    <?= $this->Form->button(__('Register'), ['class' => 'right']); ?>
    <?= $this->Form->end() ?>
</div>

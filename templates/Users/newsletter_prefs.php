<?php
// debug($user);
// die();
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <p>&nbsp;</p>
            <h3><span class="glyphicon glyphicon-cog">&nbsp;</span><?= __('Newsletter preferences') ?></h3>
            <p>&nbsp;</p>
            <?= $this->Html->link(__('Back to profile'), ['action' => 'profile'], ['class' => 'side-nav-item']) ?>
            <p>&nbsp;</p>
            This is a description of our newsletter, which motivates the user to subscribe.
            <p>&nbsp;</p>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Subscribtion preferences') ?></legend>
                <?php
                echo $this->Form->control('mail_list', ['label' => 'Subscribe']);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
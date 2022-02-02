<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InviteTranslation $inviteTranslation
 */
?>
<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-text-color"></span>&nbsp;&nbsp;&nbsp;Add Invite Translation</h2>
    <div class="column-responsive column-80">
        <div class="inviteTranslations form content">
            <?= $this->Form->create($inviteTranslation) ?>
            <fieldset>
                <legend><?= __('Add Invite Translation') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('subject');
                    echo $this->Form->control('messageBody');
                    echo $this->Form->control('messageSignature');
                    echo $this->Form->control('active');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

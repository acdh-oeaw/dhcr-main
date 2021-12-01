<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Language $language
 * @var \Cake\Collection\CollectionInterface|string[] $subscriptions
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <p>&nbsp;</p>
            <?= $this->Html->link(__('List Languages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <p>&nbsp;</p>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="languages form content">
            <?= $this->Form->create($language) ?>
            <fieldset>
                <legend><?= __('Add Language') ?></legend>
                <?php
                echo $this->Form->control('name');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Subscriptions'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="subscriptions form large-9 medium-8 columns content">
    <?= $this->Form->create($subscription) ?>
    <fieldset>
        <legend><?= __('Add Subscription') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('country_id');
            echo $this->Form->control('online_course');
            echo $this->Form->control('disciplines._ids', ['options' => $disciplines]);
            echo $this->Form->control('languages._ids', ['options' => $languages]);
            echo $this->Form->control('course_types._ids', ['options' => $courseTypes]);
            echo $this->Form->control('countries._ids', ['options' => $countries]);
            echo $this->Form->control('tadirah_objects._ids', ['options' => $tadirahObjects]);
            echo $this->Form->control('tadirah_techniques._ids', ['options' => $tadirahTechniques]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

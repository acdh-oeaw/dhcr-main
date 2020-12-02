<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $subscription->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $subscription->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Subscriptions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Notifications'), ['controller' => 'Notifications', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Notification'), ['controller' => 'Notifications', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Disciplines'), ['controller' => 'Disciplines', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discipline'), ['controller' => 'Disciplines', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Course Types'), ['controller' => 'CourseTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Course Type'), ['controller' => 'CourseTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tadirah Objects'), ['controller' => 'TadirahObjects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tadirah Object'), ['controller' => 'TadirahObjects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tadirah Techniques'), ['controller' => 'TadirahTechniques', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tadirah Technique'), ['controller' => 'TadirahTechniques', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="subscriptions form large-9 medium-8 columns content">
    <?= $this->Form->create($subscription) ?>
    <fieldset>
        <legend><?= __('Edit Subscription') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('online_course');
            echo $this->Form->control('confirmed');
            echo $this->Form->control('confirmation_key');
            echo $this->Form->control('country_id');
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

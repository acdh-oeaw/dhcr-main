<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subscription $subscription
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Subscription'), ['action' => 'edit', $subscription->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Subscription'), ['action' => 'delete', $subscription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscription->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Subscriptions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subscription'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notifications'), ['controller' => 'Notifications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notification'), ['controller' => 'Notifications', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Disciplines'), ['controller' => 'Disciplines', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discipline'), ['controller' => 'Disciplines', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Languages'), ['controller' => 'Languages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Language'), ['controller' => 'Languages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Course Types'), ['controller' => 'CourseTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Course Type'), ['controller' => 'CourseTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tadirah Objects'), ['controller' => 'TadirahObjects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tadirah Object'), ['controller' => 'TadirahObjects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tadirah Techniques'), ['controller' => 'TadirahTechniques', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tadirah Technique'), ['controller' => 'TadirahTechniques', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="subscriptions view large-9 medium-8 columns content">
    <h3><?= h($subscription->email) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($subscription->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Confirmation Key') ?></th>
            <td><?= h($subscription->confirmation_key) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($subscription->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country Id') ?></th>
            <td><?= $this->Number->format($subscription->country_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($subscription->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated') ?></th>
            <td><?= h($subscription->updated) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Online Course') ?></th>
            <td><?= $subscription->online_course ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Confirmed') ?></th>
            <td><?= $subscription->confirmed ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Disciplines') ?></h4>
        <?php if (!empty($subscription->disciplines)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subscription->disciplines as $disciplines): ?>
            <tr>
                <td><?= h($disciplines->id) ?></td>
                <td><?= h($disciplines->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Disciplines', 'action' => 'view', $disciplines->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Disciplines', 'action' => 'edit', $disciplines->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Disciplines', 'action' => 'delete', $disciplines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $disciplines->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Languages') ?></h4>
        <?php if (!empty($subscription->languages)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subscription->languages as $languages): ?>
            <tr>
                <td><?= h($languages->id) ?></td>
                <td><?= h($languages->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Languages', 'action' => 'view', $languages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Languages', 'action' => 'edit', $languages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Languages', 'action' => 'delete', $languages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $languages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Course Types') ?></h4>
        <?php if (!empty($subscription->course_types)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Course Parent Type Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subscription->course_types as $courseTypes): ?>
            <tr>
                <td><?= h($courseTypes->id) ?></td>
                <td><?= h($courseTypes->course_parent_type_id) ?></td>
                <td><?= h($courseTypes->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CourseTypes', 'action' => 'view', $courseTypes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CourseTypes', 'action' => 'edit', $courseTypes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CourseTypes', 'action' => 'delete', $courseTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseTypes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Countries') ?></h4>
        <?php if (!empty($subscription->countries)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Domain Name') ?></th>
                <th scope="col"><?= __('Stop Words') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subscription->countries as $countries): ?>
            <tr>
                <td><?= h($countries->id) ?></td>
                <td><?= h($countries->name) ?></td>
                <td><?= h($countries->domain_name) ?></td>
                <td><?= h($countries->stop_words) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Countries', 'action' => 'view', $countries->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Countries', 'action' => 'edit', $countries->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Countries', 'action' => 'delete', $countries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countries->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tadirah Objects') ?></h4>
        <?php if (!empty($subscription->tadirah_objects)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subscription->tadirah_objects as $tadirahObjects): ?>
            <tr>
                <td><?= h($tadirahObjects->id) ?></td>
                <td><?= h($tadirahObjects->name) ?></td>
                <td><?= h($tadirahObjects->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'TadirahObjects', 'action' => 'view', $tadirahObjects->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'TadirahObjects', 'action' => 'edit', $tadirahObjects->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'TadirahObjects', 'action' => 'delete', $tadirahObjects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tadirahObjects->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tadirah Techniques') ?></h4>
        <?php if (!empty($subscription->tadirah_techniques)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subscription->tadirah_techniques as $tadirahTechniques): ?>
            <tr>
                <td><?= h($tadirahTechniques->id) ?></td>
                <td><?= h($tadirahTechniques->name) ?></td>
                <td><?= h($tadirahTechniques->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'TadirahTechniques', 'action' => 'view', $tadirahTechniques->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'TadirahTechniques', 'action' => 'edit', $tadirahTechniques->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'TadirahTechniques', 'action' => 'delete', $tadirahTechniques->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tadirahTechniques->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Notifications') ?></h4>
        <?php if (!empty($subscription->notifications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col"><?= __('Subscription Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subscription->notifications as $notifications): ?>
            <tr>
                <td><?= h($notifications->id) ?></td>
                <td><?= h($notifications->course_id) ?></td>
                <td><?= h($notifications->subscription_id) ?></td>
                <td><?= h($notifications->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Notifications', 'action' => 'view', $notifications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Notifications', 'action' => 'edit', $notifications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Notifications', 'action' => 'delete', $notifications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notifications->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

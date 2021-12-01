<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 * @var string[]|\Cake\Collection\CollectionInterface $cities
 * @var string[]|\Cake\Collection\CollectionInterface $countries
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <p>&nbsp;</p>
            <?= $this->Html->link(__('List Institutions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <p>&nbsp;</p>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="institutions form content">
            <?= $this->Form->create($institution) ?>
            <fieldset>
                <legend><?= __('Edit Institution') ?></legend>
                <?php
                echo $this->Form->control('city_id', ['options' => $cities, 'empty' => true]);
                echo $this->Form->control('country_id', ['options' => $countries, 'empty' => true]);
                echo $this->Form->control('name');
                echo $this->Form->control('description');
                echo $this->Form->control('url');
                echo $this->Form->control('lon');
                echo $this->Form->control('lat');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
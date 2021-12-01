<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 * @var \Cake\Collection\CollectionInterface|string[] $cities
 * @var \Cake\Collection\CollectionInterface|string[] $countries
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
                <legend><?= __('Add Institution') ?></legend>
                <?php
                echo $this->Form->control('name');
                echo $this->Form->control('city_id', ['options' => $cities, 'empty' => true]);
                echo $this->Form->control('country_id', ['options' => $countries, 'empty' => true]);
                echo $this->Form->control('description');
                echo $this->Form->control('url');
                echo $this->Form->control('lat');
                echo $this->Form->control('lon');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
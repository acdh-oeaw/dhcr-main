<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $city
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('List Cities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <p>&nbsp;</p>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cities form content">
            <?= $this->Form->create($city) ?>
            <fieldset>
                <legend><?= __('Edit City') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('country_id', [
                        'type' => 'select',
                        'label' => 'Country',
                        'options' => $countries,
                        'default' => $city->country_id,
                    ]);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

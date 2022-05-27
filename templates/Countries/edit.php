<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $country->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $country->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Countries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="countries form content">
            <?= $this->Form->create($country) ?>
            <fieldset>
                <legend><?= __('Edit Country') ?></legend>
                <?php
                echo $this->Form->control('name');
                echo $this->Form->control('domain_name');
                echo $this->Form->control('alpha_3');
                echo $this->Form->control('stop_words');
                echo $this->Form->control('subscriptions._ids', ['options' => $subscriptions]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
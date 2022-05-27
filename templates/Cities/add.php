<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;&nbsp;Add City</h2>
    <div class="column-responsive column-80">
        <div class="cities form content">
            <?= $this->Form->create($city) ?>
            <fieldset>
                <legend><?= __('Add City') ?></legend>
                <?php
                echo $this->Form->control('name');
                echo $this->Form->control('country_id', ['options' => $countries, 'empty' => true]);
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Add City')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
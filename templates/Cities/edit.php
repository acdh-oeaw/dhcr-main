<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;&nbsp;Edit City</h2>
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
            <?= $this->Form->button(__('Update City')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
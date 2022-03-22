<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;&nbsp;Edit Institution</h2>
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
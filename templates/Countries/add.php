<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;Add Country</h2>
    <div class="column-responsive column-80">
        <div class="countries form content">
            <?= $this->Form->create($country) ?>
            <fieldset>
                <legend><?= __('Add Country') ?></legend>
                <?php
                echo $this->Form->control('name');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Save Country')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
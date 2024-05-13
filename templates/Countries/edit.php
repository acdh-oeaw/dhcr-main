<div class="row">
    <p></p>
    <h2><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Edit Country</h2>
    <div class="column-responsive column-80">
        <div class="countries form content">
            <?= $this->Form->create($country) ?>
            <fieldset>
                <legend><?= __('Edit Country') ?></legend>
                <?php
                echo $this->Form->control('name');
                ?>
            </fieldset>
            <p>&nbsp;</p>
            <?= $this->Form->button(__('Update Country')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>